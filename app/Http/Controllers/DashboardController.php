<?php

namespace App\Http\Controllers;
use App\Models\NomineeApplication;
use App\Models\SeasonAward;
use App\Models\TicketPurchase;
use App\Models\Winner;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard with relevant stats.
     */
    public function index(): Response
    {
        // Pata mtumiaji aliyeingia
        $user = auth()->user();

        // Pata maombi yote ya mtumiaji
        $userApplications = $user->nomineeApplications();

        // Hesabu takwimu za maombi
        $totalApplications = $userApplications->count();
        $pendingApplications = $user->nomineeApplications()->whereIn('status', [
            NomineeApplication::STATUS_PENDING_PAYMENT,
            NomineeApplication::STATUS_PENDING_REVIEW,
            NomineeApplication::STATUS_PAYMENT_FAILED,
        ])->count();
        $approvedApplications = $user->nomineeApplications()->where('status', NomineeApplication::STATUS_APPROVED)->count();

        // Hesabu tiketi zilizonunuliwa
        $ticketsPurchased = TicketPurchase::where('user_id', $user->id)
            ->where('status', TicketPurchase::STATUS_COMPLETED)
            ->sum('quantity');

        $stats = [
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'approvedApplications' => $approvedApplications,
            'ticketsPurchased' => (int) $ticketsPurchased,
        ];

        // Pata ombi la hivi karibuni linalosubiri kwa ajili ya 'alert'
        $pendingApplication = $user->nomineeApplications()
            ->whereIn('status', ['pending_payment', 'payment_failed', 'pending_review'])
            ->with('category:id,name')
            ->latest()
            ->first();

        $winningApplications = collect();
        $visibleWinnerYears = SeasonAward::where('can_show_winners', true)->pluck('year');

        if ($visibleWinnerYears->isNotEmpty()) {
            $approvedUserApplications = $user->nomineeApplications()
                ->where('status', NomineeApplication::STATUS_APPROVED)
                ->with('category:id,name,slug')
                ->get();

            if ($approvedUserApplications->isNotEmpty()) {
                $winners = Winner::query()
                    ->whereIn('year', $visibleWinnerYears)
                    ->whereIn('category_id', $approvedUserApplications->pluck('category_id')->unique())
                    ->with(['category:id,name,slug', 'nominee'])
                    ->get();

                $hasSourceApplicationColumn = Schema::hasColumn('nominees', 'source_application_id');

                $winningApplications = $winners
                    ->map(function (Winner $winner) use ($approvedUserApplications, $hasSourceApplicationColumn) {
                        $nominee = $winner->nominee;

                        if (!$nominee) {
                            return null;
                        }

                        if ($hasSourceApplicationColumn && $nominee->source_application_id) {
                            $application = $approvedUserApplications->firstWhere('id', $nominee->source_application_id);
                        } else {
                            $application = $approvedUserApplications->first(function (NomineeApplication $application) use ($nominee) {
                                $nomineeName = mb_strtolower(trim((string) $nominee->name));

                                return (int) $application->category_id === (int) $nominee->category_id
                                    && in_array($nomineeName, [
                                        mb_strtolower(trim((string) $application->applicant_name)),
                                        mb_strtolower(trim((string) $application->business_name)),
                                    ], true);
                            });
                        }

                        if (!$application) {
                            return null;
                        }

                        $category = $winner->category ?: $application->category;

                        return [
                            'application_id' => $application->id,
                            'nominee_name' => $nominee->name,
                            'category_name' => $category?->name,
                            'category_slug' => $category?->slug,
                            'year' => (int) $winner->year,
                            'image_url' => $nominee->image_url,
                            'results_url' => $category?->slug
                                ? route('awards.results.category', ['year' => $winner->year, 'category' => $category->slug])
                                : null,
                            'season_url' => route('awards.seasons.show', ['year' => $winner->year]),
                        ];
                    })
                    ->filter()
                    ->values();
            }
        }

        return Inertia::render('Dashboard/Index', [
            'stats' => $stats,
            'pendingApplication' => $pendingApplication,
            'winningApplications' => $winningApplications,
        ]);
    }
}
