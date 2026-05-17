<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    /**
     * Display a listing of the gallery albums.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $albums = GalleryAlbum::where('is_published', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->latest()
            ->paginate(12)
            ->through(fn ($album) => [
                'id' => $album->id,
                'name' => $album->name,
                'slug' => $album->slug,
                'description' => $album->description,
                'cover_image_url' => $album->cover_image_url,
                'posts_count' => $album->posts_count,
            ]);

        return Inertia::render('Gallery/Index', [
            'albums' => $albums,
            'title' => 'Matunzio ya Picha',
            'description' => 'Tazama matukio mbalimbali ya Business Awards kupitia picha zilizokusanywa kwenye albamu zetu.',
        ]);
    }

    /**
     * Display the specified gallery album and its photos.
     *
     * @param  \App\Models\GalleryAlbum  $album
     * @return \Inertia\Response
     */
    public function show(GalleryAlbum $album): Response
    {
        $album->load(['posts' => fn ($query) => $query->where('status', 'published')->latest()]);

        $safeAlbum = [
            'id' => $album->id,
            'name' => $album->name,
            'slug' => $album->slug,
            'description' => $album->description,
            'cover_image_url' => $album->cover_image_url,
            'posts' => $album->posts->map(fn ($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'featured_image_url' => $post->featured_image_url,
            ])->values(),
        ];

        return Inertia::render('Gallery/Show', ['album' => $safeAlbum]);
    }
}
