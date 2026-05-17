<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\VoteAttemptLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoteAttemptLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'reason', 'category_id', 'search', 'date_from', 'date_to']);

        $logs = VoteAttemptLog::query()
            ->with(['nominee:id,name,image_path', 'category:id,name'])
            ->when($request->input('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($request->input('reason'), fn ($query, $reason) => $query->where('reason', $reason))
            ->when($request->input('category_id'), fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ip_address', 'like', "%{$search}%")
                        ->orWhere('request_id', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhereHas('nominee', fn ($nomineeQuery) => $nomineeQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->input('date_from'), fn ($query, $dateFrom) => $query->where('created_at', '>=', $dateFrom))
            ->when($request->input('date_to'), fn ($query, $dateTo) => $query->where('created_at', '<=', $dateTo . ' 23:59:59'))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return Inertia::render('Admin/Votes/AttemptLogs', [
            'logs' => $logs,
            'filters' => $filters,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'statuses' => VoteAttemptLog::query()->select('status')->distinct()->orderBy('status')->pluck('status'),
            'reasons' => VoteAttemptLog::query()->select('reason')->whereNotNull('reason')->distinct()->orderBy('reason')->pluck('reason'),
            'stats' => [
                'today' => VoteAttemptLog::where('created_at', '>=', now()->startOfDay())->count(),
                'success_today' => VoteAttemptLog::where('created_at', '>=', now()->startOfDay())->where('status', 'success')->count(),
                'duplicates_today' => VoteAttemptLog::where('created_at', '>=', now()->startOfDay())->where('status', 'duplicate')->count(),
                'failed_today' => VoteAttemptLog::where('created_at', '>=', now()->startOfDay())->where('status', 'failed')->count(),
            ],
        ]);
    }
}
