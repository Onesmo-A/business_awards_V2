<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function show(Post $post): Response
    {
        // Hakikisha post iliyochaguliwa imekuwa 'published'
        if ($post->status !== 'published') {
            abort(404);
        }

        $safePost = [
            'id' => $post->id,
            'slug' => $post->slug,
            'title' => $post->title,
            'content' => $post->content,
            'featured_image_url' => $post->featured_image_url,
            'media_gallery' => $post->media_gallery_urls,
            'published_at' => $post->published_at,
        ];

        return Inertia::render('Posts/Show', [
            'post' => $safePost,
        ]);
    }
}
