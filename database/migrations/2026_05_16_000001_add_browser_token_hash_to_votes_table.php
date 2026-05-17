<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (! Schema::hasColumn('votes', 'browser_token_hash')) {
                $table->string('browser_token_hash', 64)->nullable()->after('fingerprint_js_hash');
            }

            if (! Schema::hasIndex('votes', 'votes_category_browser_token_hash_index')) {
                $table->index(['category_id', 'browser_token_hash'], 'votes_category_browser_token_hash_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasIndex('votes', 'votes_category_browser_token_hash_index')) {
                $table->dropIndex('votes_category_browser_token_hash_index');
            }

            if (Schema::hasColumn('votes', 'browser_token_hash')) {
                $table->dropColumn('browser_token_hash');
            }
        });
    }
};
