<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            foreach ($this->strictUniqueIndexes() as $indexName) {
                if (Schema::hasIndex('votes', $indexName)) {
                    $table->dropUnique($indexName);
                }
            }

            if (! Schema::hasIndex('votes', 'votes_category_fingerprint_hash_index')) {
                $table->index(['category_id', 'fingerprint_js_hash'], 'votes_category_fingerprint_hash_index');
            }
        });
    }

    public function down(): void
    {
        // Do not recreate the old strict indexes; they caused false "already voted" blocks.
    }

    /**
     * Unique indexes from older duplicate-vote strategies that are too strict
     * for public voting where many people share networks and similar devices.
     */
    private function strictUniqueIndexes(): array
    {
        return [
            'votes_category_id_fingerprint_js_unique',
            'vote_category_hash_unique',
            'votes_multi_factor_hash_unique',
            'votes_category_fingerprint_hash_unique',
        ];
    }
};
