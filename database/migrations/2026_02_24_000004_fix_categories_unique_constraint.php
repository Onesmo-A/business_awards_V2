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
        Schema::table('categories', function (Blueprint $table) {
            // 1. Futa index ya zamani inayozuia majina kujirudia kwenye table nzima
            // Jina 'categories_name_unique' ndilo linalotajwa kwenye error log
            $table->dropUnique('categories_name_unique');

            // 2. Weka index mpya inayoruhusu jina sawa mradi tu mwaka au parent_id ni tofauti
            $table->unique(['year', 'parent_id', 'name'], 'categories_year_parent_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_year_parent_name_unique');
            $table->unique('name', 'categories_name_unique');
        });
    }
};