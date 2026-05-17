<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            ContactMessage::create([
                ...$validated,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to store contact message', [
                'error' => $e->getMessage(),
                'payload' => $validated,
            ]);

            return back()->withErrors([
                'form' => 'Failed to send message. Please try again.',
            ]);
        }

        Log::info('Contact Form Submission stored', ['email' => $validated['email']]);

        /*
        Mail::send('emails.contact', ['data' => $validated], function ($message) use ($validated) {
            $message->to('admin@tanzaniabusinessawards.co.tz', 'TBA Admin')
                    ->from($validated['email'], $validated['name'])
                    ->subject('Contact Form: ' . $validated['subject']);
        });
        */

        // Rudisha nyuma na ujumbe wa mafanikio.
        return back()->with('success', 'Message sent successfully!');
    }
}
