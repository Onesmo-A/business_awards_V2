<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Nominee;
use App\Models\Vote;
use App\Models\Winner;
use App\Models\SeasonAward;
use Carbon\Carbon;

class MigrateOldData extends Command
{
    protected $signature = 'migrate:old-data';
    protected $description = 'Import data from the old database structure to the new one';

    public function handle()
    {
        $this->info('Starting data migration...');

        // 1. Hakikisha connection ya zamani ipo
        try {
            DB::connection('mysql_old')->getPdo();
        } catch (\Exception $e) {
            $this->error("Imeshindwa kuunganisha na 'mysql_old'. Hakikisha umetengeneza database na kuweka settings kwenye config/database.php");
            return;
        }

        DB::transaction(function () {
            // Mappings za kuhifadhi ID za zamani vs mpya
            $categoryMap = [];
            $nomineeMap = [];

            // 2. Hamisha Categories
            $this->info('Migrating Categories...');
            $oldCategories = DB::connection('mysql_old')->table('categories')->get();
            foreach ($oldCategories as $oldCat) {
                // Angalia kama category ipo kwa slug, kama haipo tengeneza
                $category = Category::firstOrCreate(
                    ['slug' => $oldCat->slug],
                    [
                        'name' => $oldCat->name,
                        'description' => $oldCat->description,
                        'image_path' => $oldCat->image_path,
                        'status' => 'active' // Default status
                    ]
                );
                $categoryMap[$oldCat->id] = $category->id;
            }

            // 3. Hamisha Nominees
            $this->info('Migrating Nominees...');
            $oldNominees = DB::connection('mysql_old')->table('nominees')->get();
            foreach ($oldNominees as $oldNom) {
                if (isset($categoryMap[$oldNom->category_id])) {
                    $newNominee = Nominee::create([
                        'category_id' => $categoryMap[$oldNom->category_id],
                        'year' => 2025, // Weka mwaka wa zamani (2025)
                        'name' => $oldNom->name,
                        'bio' => $oldNom->bio,
                        'image_path' => $oldNom->image_path,
                        'tiktok_url' => $oldNom->tiktok_url ?? null, // BORESHO: Hamisha tiktok_url
                        'votes_count' => $oldNom->votes_count,
                        'created_at' => $oldNom->created_at,
                        'updated_at' => $oldNom->updated_at,
                    ]);
                    $nomineeMap[$oldNom->id] = $newNominee->id;
                }
            }

            // 4. Hamisha Votes
            $this->info('Migrating Votes (Hii inaweza kuchukua muda)...');
            // Build a reverse map: nominee_id => category_id
            $nomineeToCategory = [];
            foreach ($oldNominees as $oldNom) {
                if (isset($nomineeMap[$oldNom->id]) && isset($categoryMap[$oldNom->category_id])) {
                    $nomineeToCategory[$nomineeMap[$oldNom->id]] = $categoryMap[$oldNom->category_id];
                }
            }

            $oldVotes = DB::connection('mysql_old')->table('votes')->orderBy('id')->chunk(1000, function ($votes) use ($nomineeMap, $nomineeToCategory) {
                $newVotes = [];
                foreach ($votes as $vote) {
                    if (isset($nomineeMap[$vote->nominee_id]) && isset($nomineeToCategory[$nomineeMap[$vote->nominee_id]])) {
                        $newVotes[] = [
                            'nominee_id' => $nomineeMap[$vote->nominee_id],
                            'category_id' => $nomineeToCategory[$nomineeMap[$vote->nominee_id]],
                            'ip_address' => $vote->ip_address,
                            'user_agent' => $vote->user_agent,
                            'created_at' => $vote->created_at,
                            'updated_at' => $vote->updated_at,
                        ];
                    }
                }
                if (!empty($newVotes)) {
                    Vote::insert($newVotes);
                }
            });

            // 5. Hamisha Winners (Kama wapo kwenye DB ya zamani)
            $this->info('Migrating Winners...');
            // Angalia kama table ya winners ipo kule
            $hasWinnersTable = \Schema::connection('mysql_old')->hasTable('winners');
            
            if ($hasWinnersTable) {
                $oldWinners = DB::connection('mysql_old')->table('winners')->get();
                foreach ($oldWinners as $winner) {
                    if (isset($nomineeMap[$winner->nominee_id]) && isset($categoryMap[$winner->category_id])) {
                        Winner::updateOrCreate(
                            [
                                'category_id' => $categoryMap[$winner->category_id],
                                'year' => $winner->year ?? 2025, // Default 2025 kama hamna mwaka
                            ],
                            [
                                'nominee_id' => $nomineeMap[$winner->nominee_id],
                                'position' => $winner->position ?? 1,
                                'description' => $winner->description ?? null,
                            ]
                        );
                    }
                }
            } else {
                $this->warn('Winners table not found in old database. Skipping.');
            }

            // 6. Tengeneza Misimu (Seasons) kulingana na data
            $this->info('Generating Seasons...');
            $years = Vote::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->pluck('year')
                ->merge(Winner::select('year')->distinct()->pluck('year'))
                ->unique()
                ->sort();

            foreach ($years as $year) {
                if ($year) {
                    SeasonAward::firstOrCreate(
                        ['year' => $year],
                        [
                            'theme' => "Business Awards $year",
                            'description' => "Celebrating excellence for the year $year",
                            'event_date' => Carbon::createFromDate($year, 12, 31),
                        ]
                    );
                }
            }
        });

        $this->info('Data migration completed successfully!');
    }
}