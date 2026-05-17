<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (!Schema::hasColumn('votes', 'fingerprint_js_hash')) {
                $table->string('fingerprint_js_hash', 64)->nullable()->after('fingerprint_js');
            }
        });

        DB::table('votes')
            ->select(['id', 'fingerprint_js'])
            ->whereNotNull('fingerprint_js')
            ->orderBy('id')
            ->chunkById(1000, function ($votes) {
                foreach ($votes as $vote) {
                    DB::table('votes')
                        ->where('id', $vote->id)
                        ->update([
                            'fingerprint_js_hash' => hash('sha256', $vote->fingerprint_js),
                        ]);
                }
            });

        if (! Schema::hasIndex('votes', 'votes_category_fingerprint_hash_index')) {
            Schema::table('votes', function (Blueprint $table) {
                $table->index(['category_id', 'fingerprint_js_hash'], 'votes_category_fingerprint_hash_index');
            });
        }
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasColumn('votes', 'fingerprint_js_hash')) {
                if (Schema::hasIndex('votes', 'votes_category_fingerprint_hash_index')) {
                    $table->dropIndex('votes_category_fingerprint_hash_index');
                }
                $table->dropColumn('fingerprint_js_hash');
            }
        });
    }
};
