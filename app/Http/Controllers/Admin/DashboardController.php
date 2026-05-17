<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketPurchase;
use App\Models\Post;
use App\Models\MarathonRegistration; // BORESHO: Ongeza MarathonRegistration model
use App\Models\Nominee;
use App\Models\NomineeApplication;
use App\Models\User;
use App\Models\Suggestion;
use App\Models\Vote;
use App\Models\VoteAttemptLog;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\SeasonAward; // Ongeza hii
use Inertia\Inertia;
use Illuminate\Http\Request; // Ongeza hii

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $availableYears = SeasonAward::orderBy('year', 'desc')->pluck('year')->toArray();
        if (empty($availableYears)) $availableYears = [date('Y')];
        $year = $request->input('year', $availableYears[0]);

        $stats = [
            // BORESHO: Ongeza takwimu za watumiaji (wasio admin)
            'users' => User::where('is_admin', false)->count(),
            'categories' => Category::where('year', $year)->count(), // Chuja kwa mwaka
            'nominees' => Nominee::where('year', $year)->count(), // Chuja kwa mwaka
            'posts' => Post::count(), // BORESHO: Ongeza takwimu za posts
            'votes' => Vote::whereHas('nominee', fn($q) => $q->where('year', $year))->count(), // Chuja kura za mwaka huu
            'vote_attempt_issues_today' => VoteAttemptLog::where('created_at', '>=', now()->startOfDay())
                ->whereIn('status', ['duplicate', 'blocked', 'failed'])
                ->count(),
            // BORESHO: Jumuisha status zote zinazoashiria ombi linaendelea
            'pending_applications' => NomineeApplication::whereYear('created_at', $year)->whereIn('status', [
                NomineeApplication::STATUS_PENDING_REVIEW,
                NomineeApplication::STATUS_PENDING_PAYMENT,
                NomineeApplication::STATUS_PAYMENT_FAILED,
            ])->count(),
            'suggestions' => Suggestion::count(),
            // BORESHO: Ongeza takwimu za maombi yaliyokubaliwa na kukataliwa
            'approved_applications' => NomineeApplication::whereYear('created_at', $year)->where('status', NomineeApplication::STATUS_APPROVED)->count(),
            'rejected_applications' => NomineeApplication::whereYear('created_at', $year)->where('status', NomineeApplication::STATUS_REJECTED)->count(),

            'transactions' => Transaction::count(),

            // BORESHO: Ongeza takwimu za Marathon
            'marathon_total' => MarathonRegistration::count(),
            'marathon_completed' => MarathonRegistration::where('status', 'completed')->count(),
            'marathon_pending' => MarathonRegistration::where('status', 'pending_payment')->count(),
        ];

        // BORESHO: Ongeza takwimu tuli (static) kwa ajili ya tiketi
        // BORESHO: Pata takwimu halisi za tiketi
        $stats['tickets_sold'] = TicketPurchase::where('status', TicketPurchase::STATUS_COMPLETED)->sum('quantity');
        $stats['tickets_revenue'] = TicketPurchase::where('status', TicketPurchase::STATUS_COMPLETED)->sum('total_amount');
        // REKEBISHO: Taarifa ya 'checked_in_at' ipo kwenye jedwali la 'tickets', sio 'ticket_purchases'.
        // Tunatumia 'whereHas' na 'whereNotNull' kwenye uhusiano wa 'tickets' ili kupata idadi sahihi.
        $stats['tickets_checked_in'] = Ticket::whereNotNull('checked_in_at')->count();

        // Get categories with the sum of votes from their nominees
        // BORESHO: Hakikisha tunapata kategoria za tuzo tu (child categories) na sio makundi makuu.
        // Pia, chukua zile tu zenye kura ili chati iwe safi.
        $categoryVotes = Category::withSum('nominees', 'votes_count')
            ->where('year', $year) // Chuja kwa mwaka
            ->whereNotNull('parent_id') // Hakikisha ni child category
            ->whereHas('nominees') // Hakikisha ina washiriki
            ->having('nominees_sum_votes_count', '>', 0) // Hakikisha ina angalau kura moja
            ->orderByDesc('nominees_sum_votes_count')
            ->get(['id', 'name', 'nominees_sum_votes_count']);

        // Get top 5 nominees by votes
        $topNominees = Nominee::with('category')
            ->where('year', $year) // Chuja kwa mwaka
            ->orderByDesc('votes_count')
            ->take(10)
            ->get();

        // BORESHO: Pata data ya maombi kwa siku 30 zilizopita
        $dailyApplications = NomineeApplication::query()
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) { // BORESHO: Sasa inatumia tarehe na muda kamili
                return [
                    'label' => Carbon::parse($item->date)->format('M d'),
                    'count' => $item->count,
                ];
            });

        // BORESHO: Pata data ya kura kwa siku 30 zilizopita
        $dailyVotes = Vote::query()
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) { // BORESHO: Sasa inatumia tarehe na muda kamili
                return ['label' => Carbon::parse($item->date)->format('M d'), 'count' => $item->count];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'categoryVotes' => $categoryVotes,
            'dailyApplications' => $dailyApplications,
            'dailyVotes' => $dailyVotes,
            'topNominees' => $topNominees,
            'availableYears' => $availableYears,
            'currentYear' => (int)$year,
        ]);
    }
}
