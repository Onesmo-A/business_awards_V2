<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Post;
use App\Models\Reel;
use App\Models\Sponsor;
use App\Models\MapSection;
use App\Models\HeroSection;
use Inertia\Inertia;
use App\Models\SeasonAward;
use Inertia\Response;

class WelcomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): Response
    {
         $updates = Post::query()
            ->where('type', 'update')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn ($post) => [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'published_at' => $post->published_at,
                'featured_image_url' => $post->featured_image_url,
            ]);

        $settings = Cache::remember('app_settings', 3600, function () {
            return Setting::all()->pluck('value', 'key');
        });

        $latestSeason = SeasonAward::orderBy('year', 'desc')->first();
        $currentYear = $latestSeason ? $latestSeason->year : date('Y');

        $categories = Category::query()
            ->where('year', $currentYear)
            ->where('status', 'active')
            ->whereNotNull('parent_id')
            ->withCount('nominees')
            ->with(['nominees' => function ($query) {
                $query->orderBy('name', 'asc')->take(4);
            }])
            ->orderBy('name', 'asc')
            ->take(12)
            ->get();

        $reels = Reel::query()
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get()
            ->map(fn ($reel) => [
                'id' => $reel->id,
                'type' => $reel->type,
                'title' => $reel->title ?? 'Instagram Post',
                'content' => $reel->content,
            ])
            ->values();
        
        $testimonials = $this->getTestimonials();

        $sponsors = Sponsor::where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('tier')
            ->get()
            ->groupBy('tier')
            ->map(fn ($tierSponsors) => $tierSponsors->map(fn ($sponsor) => [
                'id' => $sponsor->id,
                'name' => $sponsor->name,
                'website_url' => $sponsor->website_url,
                'tier' => $sponsor->tier,
                'logo_url' => $sponsor->logo_url,
            ])->values());

        $mapSectionModel = MapSection::where('is_active', true)->latest()->first();
        $mapSection = $mapSectionModel ? [
            'title' => $mapSectionModel->title,
            'description' => $mapSectionModel->description,
            'event_date' => $mapSectionModel->event_date,
            'event_time' => $mapSectionModel->event_time,
            'location_name' => $mapSectionModel->location_name,
            'google_maps_embed_url' => $mapSectionModel->google_maps_embed_url,
            'dress_code' => $mapSectionModel->dress_code,
        ] : null;

        $heroSlides = HeroSection::where('is_active', true)
            ->orderBy('display_order')
            ->get()
            ->map(fn ($slide) => [
                'id' => $slide->id,
                'title' => $slide->title,
                'description' => $slide->description,
                'image_url' => $slide->image_url,
                'buttons' => is_array($slide->buttons) ? $slide->buttons : [],
            ])
            ->values();

        return Inertia::render('Welcome', [
            'sponsors' => $sponsors,
            'title' => 'Home',
            'description' => 'Celebrating excellence, innovation, and integrity in Business across Africa.',
            'categories' => CategoryResource::collection($categories),
            // BORESHO: Tuma mipangilio muhimu tu na hakikisha inakuwa na cast sahihi
            'settings' => [
                'voting_active' => (bool) $settings->get('voting_active', true),
                'voting_deadline' => $settings->get('voting_deadline'),
                // Ongeza mipangilio ya nomination section
                'nomination_open_title' => $settings->get('nomination_open_title', 'Nomination Is Now Open'),
                'nomination_open_dates' => $settings->get('nomination_open_dates', '15th July - 30th August 2024'),
                // BORESHO: Ongeza data ya timeline
                'timeline' => [
                    ['title' => $settings->get('timeline_step1_title', 'Public Suggestions'), 'date' => $settings->get('timeline_step1_date', 'Aug 30 - Sep 15')],
                    ['title' => $settings->get('timeline_step2_title', 'Nominee Applications'), 'date' => $settings->get('timeline_step2_date', 'Sep 16 - Oct 10')],
                    ['title' => $settings->get('timeline_step4_title', 'Awards Gala Night'), 'date' => $settings->get('timeline_step4_date', 'Nov 03')],
                    ['title' => $settings->get('timeline_step5_title', 'Winners Announcement'), 'date' => $settings->get('timeline_step5_date', 'Nov 10')],
                ]
            ], 'updates' => $updates,

            // BORESHO: Pata Hero Slides kutoka kwenye database
            'heroSlides' => $heroSlides,

            'reels' => $reels, // NEW: Tuma reels kwenye view
            'testimonials' => $testimonials, // BORESHO: Tuma testimonials kwenye view
            'mapSection' => $mapSection, // BORESHO: Tuma data ya map section
        ]);
    }

    /**
     * BORESHO: Njia ya kupata data ya testimonials.
     * Hii inaweza kuhamishiwa kwenye model au service baadaye.
     */
    private function getTestimonials()
    {
        return [
            [
                'id' => 1,
                'body' => 'Winning the Business Award has opened new doors for partnerships across the continent. It is a true mark of excellence.',
                'author' => [
                    'name' => 'Tibakya O. A.',
                    'role' => 'CEO - Native Technology',
                    'imageUrl' => '/images/testimonials/tibakya_native_technology.jpg', 
                ],
            ],
            [
                'id' => 2,
                'body' => 'Participating in the Business Awards Africa offers significant public recognition and visibility for our brand.',
                'author' => [
                    'name' => 'Madam Juby Msuya',
                    'role' => 'Director - Juby Enterprises Ltd',
                    'imageUrl' => '/images/testimonials/msuya_juby.jpg', 
                ],
            ],
        ];
    }
}
