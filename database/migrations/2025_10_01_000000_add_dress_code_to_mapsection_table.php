
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('map_sections', function (Blueprint $table) {
			$table->string('dress_code')->nullable()->after('google_maps_embed_url');
		});
	}

	public function down(): void
	{
		Schema::table('map_sections', function (Blueprint $table) {
			$table->dropColumn('dress_code');
		});
	}
};
