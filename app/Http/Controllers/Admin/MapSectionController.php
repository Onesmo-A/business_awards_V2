<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MapSectionController extends Controller
{
    public function index()
    {
        $sections = MapSection::latest()->paginate(10);
        return Inertia::render('Admin/MapSection/Index', ['sections' => $sections]);
    }

    public function create()
    {
        return Inertia::render('Admin/MapSection/Form', ['mapSection' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|string|max:255',
            'event_time' => 'nullable|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'google_maps_embed_url' => 'nullable|string',
            'is_active' => 'required|boolean',
            'dress_code' => 'nullable|string|max:255',
        ]);

        MapSection::create($validated);

        return redirect()->route('admin.map-sections.index')->with('success', 'Event Location created successfully.');
    }

    public function edit(MapSection $mapSection)
    {
        return Inertia::render('Admin/MapSection/Form', ['mapSection' => $mapSection]);
    }

    public function update(Request $request, MapSection $mapSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|string|max:255',
            'event_time' => 'nullable|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'google_maps_embed_url' => 'nullable|string',
            'is_active' => 'required|boolean',
            'dress_code' => 'nullable|string|max:255',
        ]);

        $mapSection->update($validated);

        return redirect()->route('admin.map-sections.index')->with('success', 'Event Location updated successfully.');
    }

    public function destroy(MapSection $mapSection)
    {
        $mapSection->delete();
        return redirect()->route('admin.map-sections.index')->with('success', 'Deleted successfully.');
    }
}