<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestOfHonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GuestOfHonorController extends Controller
{
    public function index()
    {
        $guests = GuestOfHonor::latest()->get();
        return Inertia::render('Admin/GuestOfHonor/Index', ['guests' => $guests]);
    }

    public function create()
    {
        return Inertia::render('Admin/GuestOfHonor/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('guest_images', 'public');
        }

        if ($validated['is_active'] ?? false) {
            // Deactivate others if this one is active
            GuestOfHonor::where('is_active', true)->update(['is_active' => false]);
        }

        GuestOfHonor::create($validated);

        return redirect()->route('admin.guest-of-honor.index')->with('success', 'Guest created successfully.');
    }

    public function edit(GuestOfHonor $guestOfHonor)
    {
        return Inertia::render('Admin/GuestOfHonor/Edit', ['guest' => $guestOfHonor]);
    }

    public function update(Request $request, GuestOfHonor $guestOfHonor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($guestOfHonor->image_path) {
                Storage::disk('public')->delete($guestOfHonor->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('guest_images', 'public');
        }

        if ($validated['is_active'] ?? false) {
            GuestOfHonor::where('id', '!=', $guestOfHonor->id)->where('is_active', true)->update(['is_active' => false]);
        }

        $guestOfHonor->update($validated);

        return redirect()->route('admin.guest-of-honor.index')->with('success', 'Guest updated successfully.');
    }

    public function destroy(GuestOfHonor $guestOfHonor)
    {
        if ($guestOfHonor->image_path) Storage::disk('public')->delete($guestOfHonor->image_path);
        $guestOfHonor->delete();
        return redirect()->back()->with('success', 'Guest deleted.');
    }
}