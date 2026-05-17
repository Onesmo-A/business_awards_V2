<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\NomineeResultResource;
use App\Http\Resources\WinnerResource;
use App\Models\SeasonAward;
use App\Models\Category;
use App\Models\Winner;
use App\Models\Nominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class AwardsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Cache::remember('app_settings', 3600, function () {
            return \App\Models\Setting::all()->pluck('value', 'key');
        });

        // Pata misimu yote ambayo admin ameweka ionekane public.
        // Usifunge kwa uwepo wa winners pekee, kwa sababu msimu unaweza kuwa visible
        // hata kama washindi bado hawajatangazwa.
        $awardSeasons = SeasonAward::where('can_show_winners', true)
            ->orderBy('year', 'desc')
            ->get()
            ->map(fn ($season) => [
                'id' => $season->id,
                'year' => $season->year,
                'theme' => $season->theme,
                'cover_image_url' => $season->cover_image_url,
                'can_show_winners' => (bool) $season->can_show_winners,
            ])
            ->values();

        // BORESHO: Hatutumii tena setting ya jumla hapa kwa ajili ya kuonyesha orodha ya misimu.
        // Badala yake, tutaonyesha misimu yote, na kila msimu utakuwa na flag yake ya 'can_show_winners'.
        $search = $request->input('search');

        $viewData = [
            'title' => 'Award Seasons',
            'description' => 'Explore the winners and highlights from our past award seasons.',
            'awardSeasons' => $awardSeasons,
            'showWinners' => true, // Orodha ya misimu inaweza kuonekana siku zote
            'filters' => $request->only(['search']),
            'searchedWinners' => null,
        ];

        // BORESHO: Logiki ya utafutaji sasa inatafuta washindi wote bila kujali mwaka
        if ($search) { 
            $winners = Winner::with(['category', 'nominee'])
                ->has('nominee')
                ->where(function ($query) use ($search) {
                    $query->whereHas('nominee', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                })
                ->orderBy('year', 'desc')
                ->paginate(12)
                ->withQueryString();

            $viewData['searchedWinners'] = WinnerResource::collection($winners);
            $viewData['title'] = "Search Results for '{$search}'"; // Badilisha title kwa ajili ya matokeo ya utafutaji
        }

        return Inertia::render('Awards/Index', $viewData);
    }

    /**
     * BORESHO: Onyesha washindi wa msimu maalum (mwaka).
     */
    public function seasonShow(Request $request, $year)
    {
        // Jaribu kupata msimu rasmi kutoka kwenye database
        $seasonAward = SeasonAward::where('year', $year)->firstOrFail();

        $categories = collect(); // Anza na collection tupu

        // Pakia data ya washindi na kategoria tu kama admin ameruhusu
        if ($seasonAward->can_show_winners) {
            // BORESHO: Pata kategoria ambazo zina mshindi kwa MWAKA HUU pekee.
            // Hii inahakikisha ukurasa wa washindi wa 2026 unaonyesha data ya 2026 tu.
            $categories = Category::whereHas('winners', function ($query) use ($year) {
                    $query->where('year', $year)
                        // ONGEZO: Hakikisha mshindi anarejelea mshiriki wa mwaka husika pekee.
                        ->whereHas('nominee', function ($q) use ($year) {
                            $q->where('year', $year);
                        });
                })
                ->where('status', 'active')
                ->with(['winners' => function ($query) use ($year) {
                    $query->where('year', $year)->with('nominee'); // Mshindi bado atapakiwa na nominee wake
                }])
                // BORESHO: Pakia nominees wote wa mwaka huu pia (kama unataka kuwaonyesha)
                ->with(['nominees' => function ($query) use ($year) {
                    $query->where('year', $year);
                }])
                ->orderBy('name', 'asc')
                ->get();

            // Boresha muundo wa data: weka mshindi kama 'winner' object ndani ya kila kategoria.
            $categories->each(function ($category) {
                // 'winners' ni collection, tunachukua wa kwanza kwa sababu ni mmoja tu kwa mwaka.
                $category->winner = $category->winners->first();
                // Ondoa collection ya 'winners' ili kusafisha data.
                unset($category->winners);
            });
        }

        $safeCategories = $categories->map(function ($category) {
            $winner = $category->winner;

            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'winner' => $winner && $winner->nominee ? [
                    'id' => $winner->id,
                    'year' => $winner->year,
                    'nominee' => [
                        'id' => $winner->nominee->id,
                        'name' => $winner->nominee->name,
                        'bio' => $winner->nominee->bio,
                        'image_url' => $winner->nominee->image_url,
                    ],
                ] : null,
            ];
        })->values();

        $safeSeason = [
            'id' => $seasonAward->id,
            'year' => $seasonAward->year,
            'theme' => $seasonAward->theme,
            'description' => $seasonAward->description,
            'cover_image_url' => $seasonAward->cover_image_url,
            'can_show_winners' => (bool) $seasonAward->can_show_winners,
            'categories' => $safeCategories,
        ];

        return Inertia::render('Awards/SeasonShow', [
            'title' => "Award Winners {$year}",
            'description' => $safeSeason['description'] ?? "Celebrating the winners of the {$seasonAward->year} Business Awards.",
            'season' => $safeSeason,
        ]);
    }


    /**
     * @deprecated Hii method imeondolewa.
     */

    public function resultsByCategory(Request $request, $year, Category $category)
    {
        // BORESHO: Angalia setting ya msimu husika badala ya setting ya jumla
        $season = SeasonAward::where('year', $year)->first();
        
        // Ruhusu kuonyesha matokeo tu kama msimu upo NA 'can_show_winners' ni true
        $showWinners = $season && $season->can_show_winners;

        // Kama matokeo hayaruhusiwi, rudisha data tupu na status
        if (!$showWinners) {
            return Inertia::render('Awards/Results', [
                'category' => new CategoryResource($category),
                'nominees' => [],
                'year' => (int) $year,
                'winnerNomineeId' => null,
                'showResults' => false, // Kipeperushi kwa ajili ya frontend
                'title' => "Voting Results for {$category->name} ({$year})",
            ]);
        }

        // Tumia votes_count iliyohifadhiwa kwenye nominees ili matokeo ya misimu
        // iliyo archived yaendelee kuonekana bila kurudisha votes kwenye active table.
        $nominees = $category->nominees()
            ->where('year', $year)
            ->orderByDesc('votes_count')
            ->get();

        $winner = Winner::where('year', $year)
            ->where('category_id', $category->id)
            ->first();

        return Inertia::render('Awards/Results', [
            'category' => new CategoryResource($category),
            // FIX: Tumia ->resolve() kugeuza resource collection kuwa array halisi.
            // Hii ni njia thabiti zaidi ya kuhakikisha data inafika kama array
            // na kuepuka matatizo ya serialization.
            'nominees' => NomineeResultResource::collection($nominees)->resolve(),
            'year' => (int) $year,
            'winnerNomineeId' => $winner ? $winner->nominee_id : null,
            'showResults' => true, // Kipeperushi kwa ajili ya frontend
            'title' => "Voting Results for {$category->name} ({$year})",
        ]);
    }
}

