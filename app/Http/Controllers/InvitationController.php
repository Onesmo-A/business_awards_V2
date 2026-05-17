<?php

namespace App\Http\Controllers;

use App\Models\GuestInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class InvitationController extends Controller
{
    /**
     * Onyesha kadi ya mwaliko kwa kutumia UUID.
     */
    public function show(string $uuid)
    {
        // Tafuta mwaliko kwa kutumia UUID. Kama haupo, rudisha 404.
        $invitation = GuestInvitation::where('uuid', $uuid)->firstOrFail();

        // Rekodi kuwa mwaliko umefunguliwa (kama ni mara ya kwanza)
        if ($invitation->status === 'sent' || $invitation->status === 'pending') {
            $invitation->update([
                'status' => 'viewed',
                'viewed_at' => now(),
            ]);
        }

        $safeInvitation = [
            'uuid' => $invitation->uuid,
            'guest_name' => $invitation->guest_name,
            'guest_title' => $invitation->guest_title,
            'event_name' => $invitation->event_name,
            'event_description' => $invitation->event_description,
            'event_date' => $invitation->event_date,
            'event_time' => $invitation->event_time,
            'event_venue' => $invitation->event_venue,
            'dress_code' => $invitation->dress_code,
            'rsvp_status' => $invitation->rsvp_status,
        ];

        try {
            $eventYear = \Carbon\Carbon::parse($invitation->event_date)->year;
        } catch (\Throwable $e) {
            $eventYear = now()->year;
        }

        $seoTitle = "Special invitation Business awards {$eventYear}";
        $seoDescription = Str::limit(
            trim(strip_tags($invitation->event_description ?: "Special invitation to {$invitation->event_name}.")),
            155
        );
        $seoImage = URL::to('/images/logo.png');

        // Tuma data kwenye Vue component
        return Inertia::render('Invitations/Show', [
            'invitation' => $safeInvitation,
            'rsvpUrl' => URL::temporarySignedRoute(
                'invitation.rsvp',
                now()->addHours(24),
                ['uuid' => $invitation->uuid]
            ),
            // Hii itaficha navigation na footer
            'layout' => 'blank',
            'seo' => [
                'title' => $seoTitle,
                'description' => $seoDescription,
                'image' => $seoImage,
                'url' => URL::current(),
                'type' => 'website',
            ],
        ])->withViewData('seo', [
            'title' => $seoTitle,
            'description' => $seoDescription,
            'image' => $seoImage,
            'url' => URL::current(),
            'type' => 'website',
        ]);
    }

    /**
     * Hifadhi jibu la RSVP la mgeni.
     */
    public function rsvp(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'status' => 'required|in:attending,declined',
        ]);

        $invitation = GuestInvitation::where('uuid', $uuid)->firstOrFail();

        // Zuia kubadilisha jibu kama tayari ameshajibu
        if ($invitation->rsvp_status !== 'pending') {
            return back()->with('warning', 'You have already submitted your RSVP.');
        }

        $invitation->update([
            'rsvp_status' => $validated['status'],
            'rsvp_at' => now(),
        ]);

        $message = $validated['status'] === 'attending'
            ? 'Thank you for attendance. We look forward to seeing you there !'
            : 'Thank you for declining your RSVP .';

        return back()->with('success', $message);
    }
}
