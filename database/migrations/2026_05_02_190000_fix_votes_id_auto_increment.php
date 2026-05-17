<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $idColumn = DB::selectOne("\n            SELECT EXTRA, COLUMN_KEY\n            FROM INFORMATION_SCHEMA.COLUMNS\n            WHERE TABLE_SCHEMA = DATABASE()\n              AND TABLE_NAME = 'votes'\n              AND COLUMN_NAME = 'id'\n            LIMIT 1\n        ");

        if (! $idColumn) {
            return;
        }

        $hasPrimaryOnId = strtoupper((string) $idColumn->COLUMN_KEY) === 'PRI';
        $isAutoIncrement = stripos((string) $idColumn->EXTRA, 'auto_increment') !== false;

        if (! $hasPrimaryOnId) {
            DB::statement('ALTER TABLE `votes` ADD PRIMARY KEY (`id`)');
        }

        if (! $isAutoIncrement) {
            DB::statement('ALTER TABLE `votes` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    public function down(): void
    {
        // No-op: we intentionally do not remove AUTO_INCREMENT from primary keys.
    }
};
