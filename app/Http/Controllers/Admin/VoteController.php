<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Nominee;
use App\Models\Vote;
use App\Models\SeasonAward;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class VoteController extends Controller
{
    /**
     * Display a listing of votes.
     */
    public function index(Request $request)
    {
        // 1. Pata miaka yote
        $availableYears = SeasonAward::orderBy('year', 'desc')->pluck('year')->toArray();
        if (empty($availableYears)) $availableYears = [date('Y')];
        
        $year = $request->input('year', $availableYears[0]);

        $filters = $request->only(['search', 'category_id', 'date_from', 'date_to', 'year']);

        $votes = Vote::with(['nominee.category'])
            ->whereHas('nominee', function ($query) use ($year) {
                $query->where('year', $year);
            })
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('nominee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                $query->whereHas('nominee', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            })
            ->when($request->input('date_from'), function ($query, $dateFrom) {
                $query->where('created_at', '>=', $dateFrom);
            })
            ->when($request->input('date_to'), function ($query, $dateTo) {
                $query->where('created_at', '<=', $dateTo . ' 23:59:59');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Votes/Index', [
            'votes' => $votes,
            'filters' => $filters,
            'categories' => Category::where('year', $year)->orderBy('name')->get(['id', 'name']),
            'availableYears' => $availableYears,
            'currentYear' => (int)$year,
        ]);
    }

    public function archiveIndex(Request $request)
    {
        $availableYears = SeasonAward::orderBy('year', 'desc')->pluck('year')->map(fn ($year) => (int) $year)->toArray();
        if (empty($availableYears)) {
            $availableYears = [(int) date('Y')];
        }

        $beforeYear = (int) $request->input('before_year', max($availableYears));
        $pendingByYear = $this->oldVotesByYear($beforeYear);
        $archivedByYear = DB::table('voter_archives')
            ->selectRaw('season_year as year, COUNT(*) as total')
            ->groupBy('season_year')
            ->orderByDesc('season_year')
            ->get();
        $archivedForSelection = (int) DB::table('voter_archives')
            ->where('season_year', '<', $beforeYear)
            ->count();
        $pendingTotal = (int) $pendingByYear->sum('total');

        return Inertia::render('Admin/Votes/Archive', [
            'availableYears' => $availableYears,
            'beforeYear' => $beforeYear,
            'pendingByYear' => $pendingByYear,
            'pendingTotal' => $pendingTotal,
            'archivedByYear' => $archivedByYear,
            'archivedTotal' => (int) DB::table('voter_archives')->count(),
            'archivedForSelection' => $archivedForSelection,
            'archiveTotalForSelection' => $pendingTotal + $archivedForSelection,
            'batchSize' => 2000,
        ]);
    }

    public function archiveStore(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'before_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'batch_size' => ['nullable', 'integer', 'min:100', 'max:10000'],
        ]);

        $beforeYear = (int) $validated['before_year'];
        $batchSize = (int) ($validated['batch_size'] ?? 2000);

        try {
            $result = $this->archiveVoteBatch($beforeYear, $batchSize);
        } catch (\Throwable $e) {
            Log::error('Vote archive batch failed: ' . $e->getMessage(), [
                'before_year' => $beforeYear,
                'batch_size' => $batchSize,
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Archive batch imeshindwa. Tafadhali angalia laravel.log kwa maelezo zaidi.',
                ], 500);
            }

            return redirect()->route('admin.votes.archive.index', ['before_year' => $beforeYear])
                ->with('error', 'Archive batch imeshindwa. Tafadhali angalia laravel.log kwa maelezo zaidi.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $result['selected'] === 0
                    ? 'Hakuna votes za zamani zilizobaki kwa msimu uliouchagua.'
                    : "Batch imekamilika: {$result['archived']} votes zimehifadhiwa archive, {$result['deleted']} zimeondolewa kwenye active votes.",
                'result' => $result,
                'stats' => $this->archiveStats($beforeYear),
            ]);
        }

        if ($result['selected'] === 0) {
            return redirect()->route('admin.votes.archive.index', ['before_year' => $beforeYear])
                ->with('success', 'Hakuna votes za zamani zilizobaki kwa msimu uliouchagua.');
        }

        return redirect()->route('admin.votes.archive.index', ['before_year' => $beforeYear])
            ->with('success', "Batch imekamilika: {$result['archived']} votes zimehifadhiwa archive, {$result['deleted']} zimeondolewa kwenye active votes.");
    }

    /**
     * Display the Full Vote Report page.
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->only(['search', 'category_id', 'date_from', 'date_to']);

        $votes = Vote::with(['nominee.category'])
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('nominee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                $query->whereHas('nominee', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            })
            ->when($request->input('date_from'), function ($query, $dateFrom) {
                $query->where('created_at', '>=', $dateFrom);
            })
            ->when($request->input('date_to'), function ($query, $dateTo) {
                $query->where('created_at', '<=', $dateTo . ' 23:59:59');
            })
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return Inertia::render('Admin/Votes/FullReport', [
            'votes' => $votes,
            'filters' => $filters,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Download the Full Vote Report PDF.
     */
    public function downloadPdf(Request $request)
    {
        $filters = $request->only(['search', 'category_id', 'date_from', 'date_to']);
        $titleParts = ['Ripoti ya Kura'];

        $votesQuery = Vote::with(['nominee.category'])
            ->when($request->input('search'), function ($query, $search) use (&$titleParts) {
                $query->whereHas('nominee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
                $titleParts[] = 'kwa Mshiriki "' . $search . '"';
            })
            ->when($request->input('category_id'), function ($query, $categoryId) use (&$titleParts) {
                $query->whereHas('nominee', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });

                $category = Category::find($categoryId);
                if ($category) {
                    $titleParts[] = 'katika Kategoria "' . $category->name . '"';
                }
            })
            ->when($request->input('date_from'), function ($query, $dateFrom) use (&$titleParts) {
                $query->where('created_at', '>=', $dateFrom);
                $titleParts[] = 'kuanzia ' . \Carbon\Carbon::parse($dateFrom)->format('d M Y');
            })
            ->when($request->input('date_to'), function ($query, $dateTo) use (&$titleParts) {
                $query->where('created_at', '<=', $dateTo . ' 23:59:59');
                $titleParts[] = 'hadi ' . \Carbon\Carbon::parse($dateTo)->format('d M Y');
            });

        $votes = $votesQuery->latest()->get();

        $data = [
            'title' => count($titleParts) > 1 ? implode(' ', $titleParts) : 'Ripoti ya Kura Zote',
            'date' => now()->setTimezone('Africa/Nairobi')->format('d M, Y H:i'),
            'votes' => $votes,
        ];

        $pdf = Pdf::loadView('reports.votes_pdf', $data);

        return $pdf->download('ripoti-ya-kura.pdf');
    }

    /**
     * Display the Vote Summary Report page.
     */
    public function exportSummary(Request $request)
    {
        $filters = $request->only(['search', 'category_id', 'date_from', 'date_to']);

        $summary = Vote::query()
            ->join('nominees', 'nominees.id', '=', 'votes.nominee_id')
            ->leftJoin('categories', 'categories.id', '=', 'votes.category_id')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nominees.name', 'like', "%{$search}%");
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                $query->where('votes.category_id', $categoryId);
            })
            ->when($request->input('date_from'), function ($query, $dateFrom) {
                $query->where('votes.created_at', '>=', $dateFrom);
            })
            ->when($request->input('date_to'), function ($query, $dateTo) {
                $query->where('votes.created_at', '<=', $dateTo . ' 23:59:59');
            })
            ->groupBy('votes.nominee_id', 'votes.category_id', 'nominees.name', 'categories.name')
            ->orderByDesc('votes_count')
            ->get([
                DB::raw('COALESCE(categories.name, "N/A") as category'),
                DB::raw('COALESCE(nominees.name, "N/A") as nominee'),
                DB::raw('COUNT(*) as votes_count'),
            ]);

        return Inertia::render('Admin/Votes/SummaryReport', [
            'summary' => $summary,
            'filters' => $filters,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Download the Vote Summary PDF.
     */
    public function downloadSummary(Request $request)
    {
        $filters = $request->only(['search', 'category_id', 'date_from', 'date_to']);
        $titleParts = ['Summary ya Kura'];

        $summary = Vote::query()
            ->join('nominees', 'nominees.id', '=', 'votes.nominee_id')
            ->leftJoin('categories', 'categories.id', '=', 'votes.category_id')
            ->when($request->input('search'), function ($query, $search) use (&$titleParts) {
                $query->where('nominees.name', 'like', "%{$search}%");
                $titleParts[] = 'kwa Mshiriki "' . $search . '"';
            })
            ->when($request->input('category_id'), function ($query, $categoryId) use (&$titleParts) {
                $query->where('votes.category_id', $categoryId);

                $category = Category::find($categoryId);
                if ($category) {
                    $titleParts[] = 'katika Kategoria "' . $category->name . '"';
                }
            })
            ->when($request->input('date_from'), function ($query, $dateFrom) use (&$titleParts) {
                $query->where('votes.created_at', '>=', $dateFrom);
                $titleParts[] = 'kuanzia ' . \Carbon\Carbon::parse($dateFrom)->format('d M Y');
            })
            ->when($request->input('date_to'), function ($query, $dateTo) use (&$titleParts) {
                $query->where('votes.created_at', '<=', $dateTo . ' 23:59:59');
                $titleParts[] = 'hadi ' . \Carbon\Carbon::parse($dateTo)->format('d M Y');
            })
            ->groupBy('votes.nominee_id', 'votes.category_id', 'nominees.name', 'categories.name')
            ->orderByDesc('votes_count')
            ->get([
                DB::raw('COALESCE(categories.name, "N/A") as category'),
                DB::raw('COALESCE(nominees.name, "N/A") as nominee'),
                DB::raw('COUNT(*) as votes_count'),
            ]);

        $data = [
            'title' => count($titleParts) > 1 ? implode(' ', $titleParts) : 'Summary ya Kura Zote',
            'date' => now()->setTimezone('Africa/Nairobi')->format('d M, Y H:i'),
            'summary' => $summary,
        ];

        $pdf = Pdf::loadView('reports.votes_summary_pdf', $data);

        return $pdf->download('summary-ya-kura.pdf');
    }

    /**
     * Reset all votes.
     */
    public function reset(): RedirectResponse
    {
        try {
            DB::transaction(function () {
                Vote::truncate();
                Nominee::query()->update(['votes_count' => 0]);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to reset votes: ' . $e->getMessage());

            return redirect()->route('admin.dashboard')
                ->with('error', 'Kuna kosa limetokea wakati wa kureset kura. Tafadhali angalia logs.');
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kura zote zimefutwa na kuwekwa upya kikamilifu.');
    }

    private function oldVotesByYear(int $beforeYear)
    {
        return DB::table('votes as v')
            ->join('nominees as n', 'n.id', '=', 'v.nominee_id')
            ->selectRaw('n.year as year, COUNT(*) as total')
            ->where('n.year', '<', $beforeYear)
            ->groupBy('n.year')
            ->orderByDesc('n.year')
            ->get();
    }

    private function archiveStats(int $beforeYear): array
    {
        $pendingByYear = $this->oldVotesByYear($beforeYear);
        $archivedByYear = DB::table('voter_archives')
            ->selectRaw('season_year as year, COUNT(*) as total')
            ->groupBy('season_year')
            ->orderByDesc('season_year')
            ->get();
        $pendingTotal = (int) $pendingByYear->sum('total');
        $archivedForSelection = (int) DB::table('voter_archives')
            ->where('season_year', '<', $beforeYear)
            ->count();

        return [
            'pendingByYear' => $pendingByYear,
            'pendingTotal' => $pendingTotal,
            'archivedByYear' => $archivedByYear,
            'archivedTotal' => (int) DB::table('voter_archives')->count(),
            'archivedForSelection' => $archivedForSelection,
            'archiveTotalForSelection' => $pendingTotal + $archivedForSelection,
        ];
    }

    private function archiveVoteBatch(int $beforeYear, int $batchSize): array
    {
        $votes = DB::table('votes as v')
            ->join('nominees as n', 'n.id', '=', 'v.nominee_id')
            ->leftJoin('categories as c', 'c.id', '=', 'v.category_id')
            ->where('n.year', '<', $beforeYear)
            ->orderBy('v.id')
            ->limit($batchSize)
            ->get([
                'v.id',
                'n.year as season_year',
                'v.nominee_id',
                'v.category_id',
                'n.name as nominee_name',
                'c.name as category_name',
                'v.ip_address',
                'v.user_agent',
                'v.fingerprint',
                'v.fingerprint_js',
                'v.fingerprint_js_hash',
                'v.screen_resolution',
                'v.timezone',
                'v.language',
                'v.multi_factor_hash',
                'v.voted_at',
                'v.created_at',
                'v.updated_at',
            ]);

        if ($votes->isEmpty()) {
            return ['selected' => 0, 'archived' => 0, 'deleted' => 0];
        }

        $ids = [];
        $archiveRows = [];

        foreach ($votes as $vote) {
            $ids[] = (int) $vote->id;
            $archiveRows[] = [
                'original_vote_id' => $vote->id,
                'season_year' => $vote->season_year,
                'nominee_id' => $vote->nominee_id,
                'category_id' => $vote->category_id,
                'nominee_name' => $vote->nominee_name,
                'category_name' => $vote->category_name,
                'ip_address' => $vote->ip_address,
                'user_agent' => $vote->user_agent,
                'fingerprint' => $vote->fingerprint,
                'fingerprint_js' => $vote->fingerprint_js,
                'fingerprint_js_hash' => $vote->fingerprint_js_hash ?: ($vote->fingerprint_js ? hash('sha256', $vote->fingerprint_js) : null),
                'screen_resolution' => $vote->screen_resolution,
                'timezone' => $vote->timezone,
                'language' => $vote->language,
                'multi_factor_hash' => $vote->multi_factor_hash,
                'voted_at' => $vote->voted_at,
                'vote_created_at' => $vote->created_at,
                'vote_updated_at' => $vote->updated_at,
                'archived_at' => now(),
            ];
        }

        return DB::transaction(function () use ($archiveRows, $ids) {
            $archived = 0;

            foreach (array_chunk($archiveRows, 1000) as $archiveChunk) {
                $archived += DB::table('voter_archives')->insertOrIgnore($archiveChunk);
            }

            $deleted = DB::table('votes')
                ->whereIn('id', $ids)
                ->whereExists(function ($query) {
                    $query->selectRaw('1')
                        ->from('voter_archives')
                        ->whereColumn('voter_archives.original_vote_id', 'votes.id');
                })
                ->delete();

            return [
                'selected' => count($ids),
                'archived' => $archived,
                'deleted' => $deleted,
            ];
        });
    }
}
