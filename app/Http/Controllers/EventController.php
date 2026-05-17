<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function guestOfHonor(): Response
    {
        $guestModel = \App\Models\GuestOfHonor::where('is_active', true)->first();
        $guest = $guestModel ? [
            'name' => $guestModel->name,
            'title' => $guestModel->title,
            'bio' => $guestModel->bio,
            'image_url' => $guestModel->image_url,
        ] : null;

        return Inertia::render('Event/GuestOfHonor', [
            'guest' => $guest
        ]);
    }

    public function artists(): Response
    {
        return Inertia::render('Event/Artists');
    }
}
