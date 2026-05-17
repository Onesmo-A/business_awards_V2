<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasIndex('categories', 'categories_year_status_parent_index')) {
                $table->index(['year', 'status', 'parent_id'], 'categories_year_status_parent_index');
            }

            if (! Schema::hasIndex('categories', 'categories_parent_year_status_name_index')) {
                $table->index(['parent_id', 'year', 'status', 'name'], 'categories_parent_year_status_name_index');
            }
        });

        Schema::table('nominees', function (Blueprint $table) {
            if (! Schema::hasIndex('nominees', 'nominees_category_name_index')) {
                $table->index(['category_id', 'name'], 'nominees_category_name_index');
            }

            if (! Schema::hasIndex('nominees', 'nominees_year_category_votes_index')) {
                $table->index(['year', 'category_id', 'votes_count'], 'nominees_year_category_votes_index');
            }
        });

        Schema::table('season_awards', function (Blueprint $table) {
            if (! Schema::hasIndex('season_awards', 'season_awards_year_index')) {
                $table->index('year', 'season_awards_year_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('season_awards', function (Blueprint $table) {
            if (Schema::hasIndex('season_awards', 'season_awards_year_index')) {
                $table->dropIndex('season_awards_year_index');
            }
        });

        Schema::table('nominees', function (Blueprint $table) {
            if (Schema::hasIndex('nominees', 'nominees_year_category_votes_index')) {
                $table->dropIndex('nominees_year_category_votes_index');
            }

            if (Schema::hasIndex('nominees', 'nominees_category_name_index')) {
                $table->dropIndex('nominees_category_name_index');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasIndex('categories', 'categories_parent_year_status_name_index')) {
                $table->dropIndex('categories_parent_year_status_name_index');
            }

            if (Schema::hasIndex('categories', 'categories_year_status_parent_index')) {
                $table->dropIndex('categories_year_status_parent_index');
            }
        });
    }
};
