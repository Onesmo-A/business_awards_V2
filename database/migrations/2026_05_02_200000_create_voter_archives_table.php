<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('voter_archives')) {
            return;
        }

        Schema::create('voter_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_vote_id')->unique();
            $table->integer('season_year')->index();
            $table->foreignId('nominee_id')->nullable()->index();
            $table->foreignId('category_id')->nullable()->index();
            $table->string('nominee_name')->nullable();
            $table->string('category_name')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('fingerprint')->nullable();
            $table->text('fingerprint_js')->nullable();
            $table->string('fingerprint_js_hash', 64)->nullable();
            $table->string('screen_resolution')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language')->nullable();
            $table->string('multi_factor_hash')->nullable();
            $table->timestamp('voted_at')->nullable();
            $table->timestamp('vote_created_at')->nullable()->index();
            $table->timestamp('vote_updated_at')->nullable();
            $table->timestamp('archived_at')->nullable()->useCurrent();

            $table->index(['season_year', 'category_id'], 'voter_archives_season_category_index');
            $table->index(['season_year', 'nominee_id'], 'voter_archives_season_nominee_index');
            $table->index(['category_id', 'fingerprint_js_hash'], 'voter_archives_category_fingerprint_hash_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voter_archives');
    }
};
