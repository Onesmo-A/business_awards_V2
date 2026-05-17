<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Sponsor;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function about(): Response
    {
        return Inertia::render('About', [
            'title' => 'About The Business Awards',
            'description' => 'Learn more about the history, mission, and vision of the Business Excellence Awards.'
        ]);
    }

    public function getTickets(): Response
    {
        return Inertia::render('GetTickets', [
            'title' => 'Event Tickets',
            'description' => 'Secure your spot at the most anticipated business awards night. Choose your ticket package and be part of the celebration.',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Tickets', 'url' => null],
            ],
        ]);
    }

    public function sponsors(): Response
    {
        $sponsors = Sponsor::where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('tier')
            ->get()
            ->groupBy('tier')
            ->map(fn ($tierSponsors) => $tierSponsors->map(fn ($sponsor) => [
                'id' => $sponsor->id,
                'name' => $sponsor->name,
                'website_url' => $sponsor->website_url,
                'tier' => $sponsor->tier,
                'logo_url' => $sponsor->logo_url,
            ])->values());

        return Inertia::render('Sponsors/Index', [
            'title' => 'Our Sponsors & Partners',
            'description' => 'Partner with Business Awards to celebrate excellence in business and gain unparalleled visibility.',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Sponsors', 'url' => null],
            ],
            'sponsors' => $sponsors,
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact', [
            'title' => 'Contact Us',
            'description' => 'Have questions or need support? Get in touch with our team. We are here to help you with any inquiries.',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Contact', 'url' => null],
            ],
        ]);
    }

    public function participate(): Response
    {
        $forms = [
            [
                'title' => 'Nomination Form for Individuals',
                'description' => 'Use this form to nominate outstanding business leaders or professionals for the Business Awards.',
                'url' => '/downloads/individual_nomination_form.pdf',
            ],
            [
                'title' => 'Company/Organization Application Form',
                'description' => 'Companies and organizations can use this form to apply for various award categories.',
                'url' => '/downloads/company_application_form.pdf',
            ],
            [
                'title' => 'Sponsorship Package Details',
                'description' => 'Learn more about our sponsorship opportunities and how you can partner with us.',
                'url' => '/downloads/sponsorship_package.pdf',
            ]
        ];

        return Inertia::render('Participate', [
            'title' => 'Participate & Download Forms', 
            'forms' => $forms
        ]);
    }

    public function suggestNominee(): Response
    {
        $awardCategories = Category::query()
            ->where('status', 'active')
            ->whereNotNull('parent_id')
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return Inertia::render('SuggestNominee', [
            'title' => 'Suggest Outstanding Business Leaders',
            'description' => 'Do you know a business leader, company, or organization that deserves recognition? Business Awards gives you the chance to nominate candidates across various categories to honor innovation, leadership, and outstanding contributions to the business sector in Tanzania.',
            'categories' => $awardCategories,
        ]);
    }
    
}
