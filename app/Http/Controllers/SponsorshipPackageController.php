<?php

namespace App\Http\Controllers;

use App\Models\SponsorshipPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SponsorshipPackageController extends Controller
{
    /**
     * Display a listing of the sponsorship packages for the public.
     *
     * @return Response
     */
    public function index(): Response
    {
        $packages = SponsorshipPackage::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();

        return Inertia::render('SponsorsPackages/Index', [
            'packages' => $packages,
        ]);
    }
}