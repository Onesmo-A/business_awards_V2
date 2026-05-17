<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\SeasonAward;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\NomineeResource;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Onyesha kategoria maalum na washiriki wake.
     */
public function show(Category $category): Response
{
    // Pakia washiriki wote wa kategoria hii ili wawe sehemu ya 'category' object
    $category->load(['nominees' => function ($query) {
        $query->orderBy('name'); // Panga kwa majina (A-Z)
    }]);

    // Pata mipangilio kutoka kwenye cache kwa utendaji bora
    $settings = Cache::remember('app_settings', 3600, function () {
        return Setting::all()->pluck('value', 'key');
    });

    return Inertia::render('Categories/Show', [
        'category' => new CategoryResource($category),
        'settings' => [
            'voting_active' => (bool) ($settings->get('voting_active', true)),
            'voting_deadline' => $settings->get('voting_deadline') ?? null,
        ],
        'year' => $category->year,
    ]);
}


    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));

        // 1. Pata mwaka wa sasa (msimu wa hivi karibuni)
        $latestSeason = SeasonAward::orderBy('year', 'desc')->first();
        $currentYear = $latestSeason ? $latestSeason->year : date('Y');

        // Chagua makundi makuu (yale hayana mzazi)
        $categoryGroups = Category::query()
            ->where('year', $currentYear) // BORESHO: Chuja kwa mwaka
            ->where('status', 'active') // 1. Onyesha makundi makuu yaliyo 'active' tu
            ->whereNull('parent_id')
            // Pakia tuzo zilizo chini yake (children) na hesabu washiriki kwa kila tuzo
            ->with(['children' => function ($query) use ($currentYear, $search) {
                $query->where('year', $currentYear) // BORESHO: Chuja watoto kwa mwaka
                      ->where('status', 'active') // 2. Pakia tuzo zilizo 'active' tu
                      ->when($search !== '', function ($childQuery) use ($search) {
                          $childQuery->where(function ($q) use ($search) {
                              $q->where('name', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%");
                          });
                      })
                      ->withCount('nominees')
                      ->orderBy('name', 'asc');
            }])
            // 3. Hakikisha kundi kuu linaonekana tu kama lina tuzo (children) zilizo 'active'
            ->whereHas('children', function ($query) use ($currentYear) {
                $query->where('year', $currentYear)->where('status', 'active');
            })
            // Ongeza uwezo wa kutafuta kwenye makundi makuu na tuzo zake
            ->when($search !== '', function ($query) use ($search, $currentYear) {
                $query->where(function ($q) use ($search, $currentYear) {
                    $q->where('name', 'like', "%{$search}%") // Tafuta kwenye jina la kundi kuu
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('children', function ($childQuery) use ($search, $currentYear) {
                            $childQuery->where('status', 'active') // Tafuta kwenye tuzo zilizo active tu
                                       ->where('year', $currentYear)
                                       ->where(function ($childSearchQuery) use ($search) {
                                           $childSearchQuery->where('name', 'like', "%{$search}%")
                                                            ->orWhere('description', 'like', "%{$search}%");
                                       });
                        });
                });
            })
            ->orderBy('name', 'asc') // Panga makundi makuu kwa herufi
            ->paginate(10) // Weka pagination kwenye makundi makuu
            ->withQueryString();

        return Inertia::render('Categories/Index', [
            'categoryGroups' => CategoryResource::collection($categoryGroups),
            'filters' => $request->only(['search']),
            'year' => (int) $currentYear,
        ]);
    }

    /**
     * Pata kategoria za mwaka wa sasa kwa ajili ya Slider ya ukurasa wa mbele.
     * Inarudisha JSON.
     */
    public function slider()
    {
        $latestSeason = SeasonAward::orderBy('year', 'desc')->first();
        $currentYear = $latestSeason ? $latestSeason->year : date('Y');

        $categories = Category::where('year', $currentYear)
            ->where('status', 'active')
            ->whereNotNull('parent_id') // Hakikisha ni kategoria za tuzo (sio makundi)
            ->orderBy('name', 'asc')
            ->take(12) // Chukua chache kwa ajili ya slider
            ->get(['id', 'name', 'slug', 'image_path']);

        return response()->json($categories);
    }
}
