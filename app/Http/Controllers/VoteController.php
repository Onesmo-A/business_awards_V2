<?php

namespace App\Http\Controllers;

use App\Models\Nominee;
use App\Models\Setting;
use App\Models\Vote;
use App\Models\VoteAttemptLog;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

     /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request, Nominee $nominee)
{
    $validator = Validator::make($request->all(), [
        'fingerprint_js' => 'required|string|min:10',
        'browser_token' => 'nullable|string|min:16|max:128',
        'screen_resolution' => 'nullable|string|max:255',
        'timezone' => 'nullable|string|max:255',
        'language' => 'nullable|string|max:255',
    ], [
        'fingerprint_js.required' => 'A technical issue occurred, please try again (FP-JS).',
        'fingerprint_js.min' => 'A technical issue occurred, please try again (FP-JS-MIN).',
    ]);

    if ($validator->fails()) {
        $this->logVoteAttempt($request, $nominee, 'failed', 'validation_failed', [
            'message' => 'Vote validation failed.',
            'context' => ['errors' => $validator->errors()->toArray()],
        ]);

        return response()->json([
            'message' => $validator->errors()->first() ?: 'A technical issue occurred, please try again.',
            'errors' => $validator->errors(),
        ], 422);
    }

    $validated = $validator->validated();
    $fingerprintHash = $this->generateFingerprintHash($validated['fingerprint_js']);
    $browserTokenHash = $this->generateNullableHash($validated['browser_token'] ?? null);

    // --- VOTE CONTROL LOGIC ---
    $settings = Cache::remember('app_settings', 3600, function () {
        return Setting::all()->pluck('value', 'key');
    });

    // 1. Check if voting is disabled
    if (! (bool) $settings->get('voting_active', true)) {
        $this->logVoteAttempt($request, $nominee, 'blocked', 'voting_disabled', [
            'message' => 'Voting is currently disabled.',
            'fingerprint_js_hash' => $fingerprintHash,
            'browser_token_hash' => $browserTokenHash,
        ]);

        return response()->json(['message' => 'Sorry, voting is currently disabled.'], 403);
    }

    // 2. Check if the voting deadline has passed
    $deadline = $settings->get('voting_deadline');
    if ($deadline && Carbon::now()->isAfter(Carbon::parse($deadline))) {
        $this->logVoteAttempt($request, $nominee, 'blocked', 'deadline_passed', [
            'message' => 'Voting deadline has passed.',
            'fingerprint_js_hash' => $fingerprintHash,
            'browser_token_hash' => $browserTokenHash,
            'context' => ['deadline' => $deadline],
        ]);

        return response()->json(['message' => 'Sorry, the voting period has ended.'], 403);
    }

    $alreadyVoted = $browserTokenHash
        ? Vote::where('category_id', $nominee->category_id)
            ->where('fingerprint_js_hash', $fingerprintHash)
            ->where('browser_token_hash', $browserTokenHash)
            ->exists()
        : false;

    if ($alreadyVoted) {
        $this->logVoteAttempt($request, $nominee, 'duplicate', 'fingerprint_js_and_browser_token', [
            'message' => 'Fingerprint and browser token already voted in this category.',
            'fingerprint_js_hash' => $fingerprintHash,
            'browser_token_hash' => $browserTokenHash,
            'screen_resolution' => $validated['screen_resolution'] ?? null,
            'timezone' => $validated['timezone'] ?? null,
            'language' => $validated['language'] ?? null,
        ]);

        return response()->json(['message' => 'You have already voted in this category.'], 409);
    }

    // --- SAVE VOTE ---
    try {
        $vote = DB::transaction(function () use ($request, $nominee, $validated, $fingerprintHash, $browserTokenHash) {
            return $nominee->votes()->create([
                'category_id' => $nominee->category_id, // MUHIMU: Hifadhi category_id
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'fingerprint_js' => $validated['fingerprint_js'] ?? null,
                'fingerprint_js_hash' => $fingerprintHash,
                'browser_token_hash' => $browserTokenHash,
                'screen_resolution' => $validated['screen_resolution'] ?? null,
                'timezone' => $validated['timezone'] ?? null,
                'language' => $validated['language'] ?? null,
                'voted_at' => now(),
            ]);
        });
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->errorInfo[1] == 1062) {
            $this->logVoteAttempt($request, $nominee, 'failed', 'database_unique_constraint', [
                'message' => 'A database unique constraint blocked the vote. Run the latest migrations to remove strict vote unique indexes.',
                'fingerprint_js_hash' => $fingerprintHash,
                'browser_token_hash' => $browserTokenHash,
                'screen_resolution' => $validated['screen_resolution'] ?? null,
                'timezone' => $validated['timezone'] ?? null,
                'language' => $validated['language'] ?? null,
                'context' => ['error' => $e->getMessage()],
            ]);

            return response()->json(['message' => 'We could not record your vote, please try again.'], 500);
        }

        $this->logVoteAttempt($request, $nominee, 'failed', 'db_error', [
            'message' => 'Vote creation DB error.',
            'fingerprint_js_hash' => $fingerprintHash,
            'browser_token_hash' => $browserTokenHash,
            'screen_resolution' => $validated['screen_resolution'] ?? null,
            'timezone' => $validated['timezone'] ?? null,
            'language' => $validated['language'] ?? null,
            'context' => ['error' => $e->getMessage()],
        ]);

        Log::error('Vote creation DB error for nominee ' . $nominee->id, ['error' => $e->getMessage(), 'ip' => $request->ip()]);
        return response()->json(['message' => 'Server error, please try again later.'], 500);
    }

    $this->logVoteAttempt($request, $nominee, 'success', 'vote_recorded', [
        'message' => 'Vote recorded successfully.',
        'vote_id' => $vote->id,
        'fingerprint_js_hash' => $fingerprintHash,
        'browser_token_hash' => $browserTokenHash,
        'screen_resolution' => $validated['screen_resolution'] ?? null,
        'timezone' => $validated['timezone'] ?? null,
        'language' => $validated['language'] ?? null,
    ]);

    // --- SUCCESS RESPONSE ---
    return response()->json([
        'message' => 'Thank you! Your vote has been received.',
    ], 200);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateFingerprintHash(string $fingerprintJs): string
    {
        return hash('sha256', $fingerprintJs);
    }

    private function generateNullableHash(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return hash('sha256', $value);
    }

    private function logVoteAttempt(Request $request, Nominee $nominee, string $status, string $reason, array $data = []): void
    {
        $requestId = (string) Str::uuid();
        $payload = [
            'status' => $status,
            'reason' => $reason,
            'nominee_id' => $nominee->id,
            'category_id' => $nominee->category_id,
            'vote_id' => $data['vote_id'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'fingerprint_js_hash' => $data['fingerprint_js_hash'] ?? null,
            'browser_token_hash' => $data['browser_token_hash'] ?? null,
            'screen_resolution' => $data['screen_resolution'] ?? null,
            'timezone' => $data['timezone'] ?? null,
            'language' => $data['language'] ?? null,
            'request_id' => $requestId,
            'message' => $data['message'] ?? null,
            'context' => $data['context'] ?? null,
        ];

        try {
            VoteAttemptLog::create($payload);
        } catch (\Throwable $e) {
            Log::error('Failed to write vote attempt log', [
                'request_id' => $requestId,
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }

        $logLevel = $status === 'failed' ? 'error' : ($status === 'success' ? 'info' : 'warning');
        Log::log($logLevel, 'Vote attempt: ' . $reason, $payload);
    }
}
