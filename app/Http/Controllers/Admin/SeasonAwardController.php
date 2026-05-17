<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeasonAward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SeasonAwardController extends Controller
{
    public function index()
    {
        $seasons = SeasonAward::orderBy('year', 'desc')->get();
        return Inertia::render('Admin/Seasons/Index', ['seasons' => $seasons]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|unique:season_awards,year',
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'can_show_winners' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image_path'] = $request->file('cover_image')->store('season_covers', 'public');
        }

        SeasonAward::create($validated);

        return redirect()->back()->with('success', 'Season created successfully.');
    }

    public function update(Request $request, SeasonAward $season)
    {
        $validated = $request->validate([
            'year' => 'required|integer|unique:season_awards,year,' . $season->id,
            'theme' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'can_show_winners' => 'boolean',
        ]);

        $data = $validated;

        if ($request->hasFile('cover_image')) {
            // Futa picha ya zamani kama ipo
            if ($season->cover_image_path) {
                Storage::disk('public')->delete($season->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('season_covers', 'public');
        }

        // Ondoa 'cover_image' kwenye array ya data kwani hatuihifadhi moja kwa moja kwenye DB column hiyo
        unset($data['cover_image']);

        $season->update($data);

        return redirect()->back()->with('success', 'Season updated successfully.');
    }

    public function destroy(SeasonAward $season)
    {
        if ($season->cover_image_path) {
            Storage::disk('public')->delete($season->cover_image_path);
        }
        
        $season->delete();

        return redirect()->back()->with('success', 'Season deleted successfully.');
    }
}