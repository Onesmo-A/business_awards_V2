<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SponsorshipPackageController extends Controller
{
    public function index()
    {
        $packages = SponsorshipPackage::orderBy('display_order')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/SponsorshipPackages/Index', [
            'packages' => $packages,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/SponsorshipPackages/Form', [
            'sponsorshipPackage' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sponsorship_packages,name',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        SponsorshipPackage::create($validated);

        return redirect()->route('admin.sponsorship-packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function edit(SponsorshipPackage $sponsorshipPackage)
    {
        return Inertia::render('Admin/SponsorshipPackages/Form', [
            'sponsorshipPackage' => $sponsorshipPackage,
        ]);
    }

    public function update(Request $request, SponsorshipPackage $sponsorshipPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sponsorship_packages,name,' . $sponsorshipPackage->id,
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $sponsorshipPackage->update($validated);

        return redirect()->route('admin.sponsorship-packages.index')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(SponsorshipPackage $sponsorshipPackage)
    {
        $sponsorshipPackage->delete();

        return redirect()->route('admin.sponsorship-packages.index')
            ->with('success', 'Package deleted successfully.');
    }
}