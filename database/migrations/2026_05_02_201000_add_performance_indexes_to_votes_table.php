<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (! Schema::hasIndex('votes', 'votes_nominee_id_index')) {
                $table->index('nominee_id', 'votes_nominee_id_index');
            }

            if (! Schema::hasIndex('votes', 'votes_created_at_index')) {
                $table->index('created_at', 'votes_created_at_index');
            }

            if (! Schema::hasIndex('votes', 'votes_category_created_at_index')) {
                $table->index(['category_id', 'created_at'], 'votes_category_created_at_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasIndex('votes', 'votes_category_created_at_index')) {
                $table->dropIndex('votes_category_created_at_index');
            }

            if (Schema::hasIndex('votes', 'votes_created_at_index')) {
                $table->dropIndex('votes_created_at_index');
            }

            if (Schema::hasIndex('votes', 'votes_nominee_id_index')) {
                $table->dropIndex('votes_nominee_id_index');
            }
        });
    }
};
