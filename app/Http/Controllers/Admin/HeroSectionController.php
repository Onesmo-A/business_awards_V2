<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HeroSectionController extends Controller
{
    public function index()
    {
        $slides = HeroSection::orderBy('display_order')->get();
        return Inertia::render('Admin/HeroSection/Index', ['slides' => $slides]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSlide($request);

        $imagePath = $request->file('image')->store('hero_images', 'public');
        $validated['image_path'] = $imagePath;

        // Hakikisha 'buttons' ni array
        $validated['buttons'] = $validated['buttons'] ?? [];

        HeroSection::create($validated);

        return redirect()->route('admin.hero-sections.index')->with('success', 'Slide created successfully.');
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $this->validateSlide($request, $heroSection->id, false);

        $updateData = $validated;

        if ($request->hasFile('image')) {
            if ($heroSection->image_path) {
                Storage::disk('public')->delete($heroSection->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('hero_images', 'public');
        }

        // Hakikisha 'buttons' ni array
        $updateData['buttons'] = $updateData['buttons'] ?? [];

        $heroSection->update($updateData);

        return redirect()->route('admin.hero-sections.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(HeroSection $heroSection)
    {
        if ($heroSection->image_path) {
            Storage::disk('public')->delete($heroSection->image_path);
        }
        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')->with('success', 'Slide deleted successfully.');
    }

    private function validateSlide(Request $request, $slideId = null, bool $requireImage = true): array
    {
        $imageRule = $requireImage ? 'required' : 'nullable';

        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => [$imageRule, 'image', 'max:2048'],
            'is_active' => 'required|boolean',
            'display_order' => 'required|integer|min:0',
            'buttons' => 'nullable|array',
            'buttons.*.text' => 'required|string|max:50',
            'buttons.*.link' => 'required|string|max:255',
            'buttons.*.primary' => 'required|boolean',
        ]);
    }
}