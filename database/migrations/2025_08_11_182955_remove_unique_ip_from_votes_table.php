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
        Schema::table('votes', function (Blueprint $table) {
            // 1. Ongeza index ya kawaida kwanza ili Foreign Key iweze kuitumia
            // Hii inazuia error 1553 kwa kuipa foreign key index mbadala
            $table->index('nominee_id');

            // 2. Sasa ni salama kufuta unique index
            $table->dropUnique('votes_nominee_id_ip_address_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // Rudisha unique index kama ilivyokuwa awali
            $table->unique(['nominee_id', 'ip_address'], 'votes_nominee_id_ip_address_unique');
            
            // Futa index ya kawaida tuliyoongeza
            $table->dropIndex(['nominee_id']);
        });
    }
};
