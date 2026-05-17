<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vote_attempt_logs')) {
            return;
        }

        Schema::create('vote_attempt_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status', 40)->index();
            $table->string('reason', 80)->nullable()->index();
            $table->foreignId('nominee_id')->nullable()->index();
            $table->foreignId('category_id')->nullable()->index();
            $table->foreignId('vote_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('fingerprint_js_hash', 64)->nullable()->index();
            $table->string('browser_token_hash', 64)->nullable()->index();
            $table->string('screen_resolution')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language')->nullable();
            $table->string('request_id', 64)->nullable()->index();
            $table->string('message')->nullable();
            $table->json('context')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'status'], 'vote_attempt_logs_created_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vote_attempt_logs');
    }
};
