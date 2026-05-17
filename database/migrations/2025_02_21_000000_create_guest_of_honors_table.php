<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guest_of_honors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // Mfano: Waziri wa Habari
            $table->text('bio')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(false); // Mgeni wa mwaka huu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_of_honors');
    }
};