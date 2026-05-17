<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $sponsors = Sponsor::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('display_order')
            ->orderBy('tier')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Sponsors/Index', [
            'sponsors' => $sponsors,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Sponsors/Form', [
            'sponsor' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSponsor($request);

        $logoPath = $request->file('logo')->store('sponsors', 'public');
        $validated['logo_path'] = $logoPath;

        Sponsor::create($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor created successfully.');
    }

    public function edit(Sponsor $sponsor)
    {
        return Inertia::render('Admin/Sponsors/Form', [
            'sponsor' => $sponsor,
        ]);
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $this->validateSponsor($request, $sponsor->id, false);

        $updateData = $validated;

        if ($request->hasFile('logo')) {
            if ($sponsor->logo_path) {
                Storage::disk('public')->delete($sponsor->logo_path);
            }
            $updateData['logo_path'] = $request->file('logo')->store('sponsors', 'public');
        }

        $sponsor->update($updateData);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo_path) {
            Storage::disk('public')->delete($sponsor->logo_path);
        }
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }

    private function validateSponsor(Request $request, $sponsorId = null, bool $requireLogo = true): array
    {
        $logoRule = $requireLogo ? 'required' : 'nullable';

        return $request->validate([
            'name' => 'required|string|max:255',
            'logo' => [$logoRule, 'image', 'max:2048'],
            'website_url' => 'nullable|url|max:255',
            'tier' => 'required|in:main,platinum,gold,silver,bronze,partner',
            'is_active' => 'required|boolean',
            'display_order' => 'required|integer|min:0',
        ]);
    }
}