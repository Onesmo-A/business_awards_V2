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
        Schema::table('nominee_applications', function (Blueprint $table) {
            // Adding new fields after applicant_name
            $table->string('business_name')->nullable()->after('applicant_name');
            $table->integer('age')->nullable()->after('business_name');
            $table->string('nationality')->nullable()->after('age');
            $table->string('country_of_residence')->nullable()->after('nationality');
            $table->string('city')->nullable()->after('country_of_residence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominee_applications', function (Blueprint $table) {
            $table->dropColumn(['business_name', 'age', 'nationality', 'country_of_residence', 'city']);
        });
    }
};