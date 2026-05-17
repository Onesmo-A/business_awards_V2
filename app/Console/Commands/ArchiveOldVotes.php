<?php

namespace App\Console\Commands;

use App\Models\SeasonAward;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveOldVotes extends Command
{
    protected $signature = 'votes:archive
        {--before-year= : Archive votes for nominee seasons older than this year}
        {--chunk=1000 : Number of votes to process per batch}
        {--delete : Delete archived votes from the active votes table}
        {--force : Skip confirmation prompts}';

    protected $description = 'Archive old-season votes into voter_archives and optionally remove them from active votes.';

    public function handle(): int
    {
        $beforeYear = (int) ($this->option('before-year') ?: $this->defaultBeforeYear());
        $chunkSize = max(100, (int) $this->option('chunk'));
        $deleteAfterArchive = (bool) $this->option('delete');

        $total = DB::table('votes as v')
            ->join('nominees as n', 'n.id', '=', 'v.nominee_id')
            ->where('n.year', '<', $beforeYear)
            ->count();

        $this->info("Found {$total} votes older than season {$beforeYear}.");

        if ($total === 0) {
            return self::SUCCESS;
        }

        if (! $deleteAfterArchive) {
            $this->warn('Dry run only. Add --delete to archive and remove old votes from the active votes table.');
            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("Archive and delete {$total} active votes older than {$beforeYear}?")) {
            $this->warn('Cancelled.');
            return self::FAILURE;
        }

        $archived = 0;
        $deleted = 0;
        $lastId = 0;

        do {
            $votes = DB::table('votes as v')
                ->join('nominees as n', 'n.id', '=', 'v.nominee_id')
                ->leftJoin('categories as c', 'c.id', '=', 'v.category_id')
                ->where('n.year', '<', $beforeYear)
                ->where('v.id', '>', $lastId)
                ->orderBy('v.id')
                ->limit($chunkSize)
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
                break;
            }

            $ids = [];
            $archiveRows = [];

            foreach ($votes as $vote) {
                $lastId = (int) $vote->id;
                $ids[] = $lastId;

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

            DB::transaction(function () use ($archiveRows, $ids, &$archived, &$deleted) {
                $archived += DB::table('voter_archives')->insertOrIgnore($archiveRows);

                $deleted += DB::table('votes')
                    ->whereIn('id', $ids)
                    ->whereExists(function ($query) {
                        $query->selectRaw('1')
                            ->from('voter_archives')
                            ->whereColumn('voter_archives.original_vote_id', 'votes.id');
                    })
                    ->delete();
            });

            $this->line("Processed up to vote id {$lastId}...");
        } while ($votes->count() === $chunkSize);

        $this->info("Archived {$archived} new votes.");
        $this->info("Deleted {$deleted} active votes that are safely archived.");

        return self::SUCCESS;
    }

    private function defaultBeforeYear(): int
    {
        return (int) (SeasonAward::max('year') ?: now()->year);
    }
}
