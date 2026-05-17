<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\NomineeApplication; // BORESHO: Ongeza notisi mpya
use App\Models\Setting;
use App\Models\SeasonAward;
use App\Notifications\NewNomineeApplication;
use App\Jobs\InitiateZenoPayPayment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Notifications\ApplicationSubmitted;
use Inertia\Response as InertiaResponse;

class NomineeApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $statusFilters = [
            'pending' => [
                NomineeApplication::STATUS_PENDING_PAYMENT,
                NomineeApplication::STATUS_PENDING_REVIEW,
                NomineeApplication::STATUS_PAYMENT_FAILED,
            ],
            'approved' => [NomineeApplication::STATUS_APPROVED],
        ];

        $applications = auth()->user()->nomineeApplications()
            ->has('category') // ONGEZA: Hakikisha maombi yana kategoria halali kabla ya kuyaonyesha
            ->with(['category:id,name', 'transaction']) // ONGEZA: Pakia 'transaction' ili data ya malipo ipatikane
            ->when(isset($statusFilters[$status]), function ($query) use ($statusFilters, $status) {
                $query->whereIn('status', $statusFilters[$status]);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('User/Applications/Index', [
            'applications' => $applications,
            'statusFilter' => $status,
        ]);
    }

    /**
     * Hatua ya 1: Onyesha ukurasa wa kuchagua kategoria.
     * Hii inaitwa na route 'user.applications.selectCategory'.
     */
    public function selectCategory(): InertiaResponse
    {
        // 1. Tumia Policy kuzuia mtumiaji kuanza ombi jipya kama tayari ana ombi linaloendelea.
        // Hii inazuia maombi mengi kwa wakati mmoja.
        // BORESHO: Policy imebadilishwa kuruhusu maombi mapya hata kama kuna mengine yanasubiri malipo.
        Gate::authorize('create', NomineeApplication::class);

        // Pata mwaka wa sasa (msimu wa hivi karibuni)
        $latestSeason = SeasonAward::orderBy('year', 'desc')->first();
        $currentYear = $latestSeason ? $latestSeason->year : date('Y');

        // 2. Pata makundi makuu ya tuzo (yale hayana parent_id).
        // Kisha, kwa kila kundi, pakia 'children' (tuzo zenyewe) ambazo
        // zinaruhusu maombi (`status` = 'active').
        $categoryGroups = Category::query()
            ->where('year', $currentYear) // Filter parent categories by year
            ->whereNull('parent_id')
            ->with(['children' => function ($query) use ($currentYear) {
                // Chuja watoto (tuzo) ili zibaki zile tu zinazopokea maombi
                $query->where('year', $currentYear)->where('status', 'active')->orderBy('name');
            }])
            // Chuja makundi makuu ili yabaki yale tu yenye tuzo zinazopokea maombi
            ->whereHas('children', function ($query) use ($currentYear) {
                $query->where('year', $currentYear)->where('status', 'active');
            })
            ->orderBy('name')
            ->get();

        $settings = Cache::remember('app_settings', 3600, function () {
            return Setting::all()->pluck('value', 'key');
        });
        $allowOnlineApplications = (bool) $settings->get('allow_online_applications', true);
        $supportPhone = $settings->get('application_support_phone', '+255 652 724 557');

        // 3. Tuma data kwenda kwenye Vue component.
        return Inertia::render('User/Applications/SelectCategory', [
            'categoryGroups' => $categoryGroups,
            'allowOnlineApplications' => $allowOnlineApplications,
            'supportPhone' => $supportPhone,
        ]);
    }

    /**
     * Hatua ya 2: Onyesha fomu ya kujaza kwa kategoria maalum.
     * Hii inaitwa na route 'user.applications.create'.
     */
    public function create(Category $category)
    {
        $settings = Cache::remember('app_settings', 3600, function () {
            return Setting::all()->pluck('value', 'key');
        });
        $allowOnlineApplications = (bool) $settings->get('allow_online_applications', true);

        if (!$allowOnlineApplications) {
             return redirect()->route('user.applications.selectCategory')->with('error', 'Online applications are currently closed.');
        }

        return Inertia::render('User/Applications/Create', [
            'title' => 'Jaza Fomu: ' . $category->name,
            'selectedCategory' => $category,
            // BORESHO: Pata ada kutoka kwenye kategoria husika badala ya config file.
            'nomination_fee' => (int) $category->nomination_fee, 
            'is_free' => (bool) $category->is_free || $category->nomination_fee == 0, // BORESHO: Tambua kama bure pia ikiwa ada ni 0
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $settings = Cache::remember('app_settings', 3600, function () {
            return Setting::all()->pluck('value', 'key');
        });
        $allowOnlineApplications = (bool) $settings->get('allow_online_applications', true);

        if (!$allowOnlineApplications) {
             return redirect()->route('user.applications.selectCategory')->with('error', 'Online applications are currently closed.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'applicant_name' => 'required|string|max:255', // Full Name
            'business_name' => 'nullable|string|max:255',   // Business/Stage Name
            'age' => 'required|integer|min:18|max:120',     // Age
            'nationality' => 'required|string|max:100',     // Nationality
            'country_of_residence' => 'required|string|max:100', // Country
            'city' => 'required|string|max:100',            // City
            // Legeza sheria ya awali ili kupokea miundo mbalimbali ya namba
            'applicant_phone' => 'required|string|min:9|max:15',
            'applicant_email' => 'required|email|max:255',
            'bio' => 'required|string|max:2000',
            'photo' => 'nullable|image|max:2048',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
        ]);

        // Safisha na hakiki namba ya simu iwe katika muundo wa 255...
        $normalizedPhone = (string) Str::of($validated['applicant_phone'])
            ->replace(' ', '')
            ->replace('+', '');

        if (Str::startsWith($normalizedPhone, '0')) {
            $normalizedPhone = '255' . substr($normalizedPhone, 1);
        } elseif (strlen($normalizedPhone) === 9 && (Str::startsWith($normalizedPhone, '7') || Str::startsWith($normalizedPhone, '6'))) {
            $normalizedPhone = '255' . $normalizedPhone;
        }

        // Baada ya kuisafisha, hakiki tena kama iko sahihi kabla ya kuendelea
        if (!preg_match('/^255[67]\d{8}$/', $normalizedPhone)) {
            // Rudisha kosa maalum la namba ya simu ambalo litaonekana kwenye fomu
            return back()->withErrors([
                'applicant_phone' => 'Invalid phone number format. Please use a valid format (e.g., 07XXXXXXXX or 2557XXXXXXXX).'
            ])->withInput();
        }

        // REKEBISHO: Pata kategoria na ada yake kutoka kwenye database
        $category = Category::findOrFail($validated['category_id']);
        $isFree = (bool) $category->is_free || $category->nomination_fee == 0; // BORESHO: Tambua kama bure ikiwa ada ni 0
        $applicationFee = $isFree ? 0 : $category->nomination_fee;

        $application = null;

        try {
            // BORESHO: Ongeza $isFree kwenye 'use'
            $application = DB::transaction(function () use ($request, $validated, $normalizedPhone, $applicationFee, $isFree) {
                $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('nominee_photos', 'public') : null;

                $application = NomineeApplication::create([
                    'user_id' => $request->user()->id,
                    'category_id' => $validated['category_id'],
                    'applicant_name' => $validated['applicant_name'],
                    'business_name' => $validated['business_name'] ?? null,
                    'age' => $validated['age'],
                    'nationality' => $validated['nationality'],
                    'country_of_residence' => $validated['country_of_residence'],
                    'city' => $validated['city'],
                    // Hifadhi namba halisi aliyoingiza mtumiaji kwenye application
                    'applicant_phone' => $validated['applicant_phone'],
                    'applicant_email' => $validated['applicant_email'],
                    'bio' => $validated['bio'],
                    'photo_path' => $photoPath,
                    'facebook_url' => $validated['facebook_url'] ?? null,
                    'instagram_url' => $validated['instagram_url'] ?? null,
                    'tiktok_url' => $validated['tiktok_url'] ?? null,
                    // BORESHO: Weka status kulingana na kama kategoria ni ya bure
                    'status' => $isFree ? NomineeApplication::STATUS_PENDING_REVIEW : NomineeApplication::STATUS_PENDING_PAYMENT,
                ]);

                // BORESHO: Tengeneza transaction tu kama kategoria ina malipo
                if (!$isFree) {
                    $application->transaction()->create([
                        'user_id' => $request->user()->id,
                        'order_id' => (string) Str::uuid(),
                        'amount' => $applicationFee,
                        'status' => 'pending',
                        // Tumia namba iliyosafishwa kwa ajili ya muamala wa malipo
                        'phone_number' => $normalizedPhone,
                    ]);
                }

                return $application;
            });

            // Dispatch jobs OUTSIDE the transaction to ensure data is committed first
            if ($application) {
                // BORESHO: Anzisha malipo tu kama kategoria si ya bure
                if (!$isFree && $application->transaction) {
                    InitiateZenoPayPayment::dispatch($application->transaction);
                }

                // Tuma notisi kwa mtumiaji
                try {
                    $request->user()->notify(new ApplicationSubmitted($application));
                } catch (\Exception $e) {
                    Log::error('Failed to send application submitted notification to user.', 
                        ['user_id' => $request->user()->id, 'application_id' => $application->id, 'error' => $e->getMessage()]);
                }

                // BORESHO: Tuma notisi kwa Admin ikiwa ni Free Application
                // (Kwa zilizolipiwa, WebhookController itatuma baada ya malipo)
                if ($isFree) {
                    try {
                        $admins = User::where('is_admin', true)->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new NewNomineeApplication($application));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to send admin notification for free application.', ['error' => $e->getMessage()]);
                    }
                }
            }

            // BORESHO: Elekeza mtumiaji kulingana na aina ya ombi
            if ($isFree) {
                return redirect()->route('user.applications.index')->with('success', 'Your application has been received and is pending review.');
            } else {
                return redirect()->route('user.applications.show', $application->id)->with('success', 'Application received. Please wait for the payment prompt on your phone.');
            }

        } catch (\Exception $e) {
            Log::critical('Nomination Application Store Failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'A technical error occurred. Please contact support.');
        }
    }

    public function show(NomineeApplication $application): InertiaResponse
    {
        $this->authorize('view', $application);
    
        // Pakia mahusiano (relationships) muhimu
        // Transaction ni muhimu kwa ajili ya kuonyesha status ya malipo kwenye Show.vue
        $application->load(['category:id,name,slug', 'transaction']);
    
        // BORESHO: Kagua kama kategoria ya ombi hili bado ipo.
        // Kama haipo, huenda ilifutwa. Ni bora kumrudisha mtumiaji na ujumbe.
        if (!$application->category) {
            return redirect()->route('user.applications.index')
                ->with('error', 'Sorry, the category for this application is no longer available.');
        }
    
        return Inertia::render('User/Applications/Show', [
            'application' => $application,
        ]);
    }

    public function retryPayment(NomineeApplication $application): \Illuminate\Http\RedirectResponse
    {
        // REKEBISHO: Tumia policy sahihi ya 'retryPayment' badala ya 'update'.
        $this->authorize('retryPayment', $application);

        if (!in_array($application->status, ['pending_payment', 'payment_failed'])) {
            return back()->with('error', 'You cannot retry payment for this application.');
        }

        $transaction = $application->transaction;
        if (!$transaction) {
            return back()->with('error', 'No transaction record found for this application.');
        }

        try {
            // BORESHO: Tengeneza order_id mpya kabla ya kutuma ombi la malipo.
            // Hii inazuia kutumia order_id ya zamani na inahakikisha kila jaribio la malipo ni la kipekee.
            DB::transaction(function () use ($application, $transaction) {
                $application->update(['status' => 'pending_payment']);

                $transaction->update([
                    'status' => 'pending',
                    'notes' => 'Retry payment initiated by user.',
                    // Tengeneza Order ID mpya kwa ajili ya jaribio hili jipya
                    'order_id' => (string) Str::uuid(),
                ]);
            });

            // After the DB transaction is committed, we MUST refresh the local model
            // instance to get the new 'order_id' that was just saved.
            $transaction->refresh();

            // Dispatch the job with the refreshed transaction data.
            // This ensures the job receives the new, unique order_id.
            InitiateZenoPayPayment::dispatch($transaction);

            return redirect()->route('user.applications.show', $application->id)->with('success', 'New payment request sent. Please complete the payment on your phone.');
        } catch (\Exception $e) {
            Log::critical('Payment Retry Failed', ['application_id' => $application->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to initiate payment. Please try again later.');
        }
    }

    /**
     * Sasisha taarifa za ombi (kama bado halijakubaliwa).
     */
    public function update(Request $request, NomineeApplication $application)
    {
        $this->authorize('update', $application);

        // Zuia kuedit kama ombi limeshakubaliwa au kukataliwa
        if (in_array($application->status, [NomineeApplication::STATUS_APPROVED, NomineeApplication::STATUS_REJECTED])) {
            return back()->with('error', 'You cannot edit this application at this stage.');
        }

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'nationality' => 'required|string|max:100',
            'country_of_residence' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'applicant_phone' => 'required|string|max:20',
            'applicant_email' => 'required|email|max:255',
            'bio' => 'required|string|max:2000',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($application->photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($application->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('nominee_photos', 'public');
        }

        // BORESHO: Ondoa 'photo' kutoka kwa data iliyoidhinishwa kabla ya kusasisha.
        // Hii inazuia kujaribu kuhifadhi faili lenyewe kwenye database badala ya njia yake (path).
        unset($validated['photo']);

        $application->update($validated);

        return back()->with('success', 'Info Updated Successfully.');
    }
}
