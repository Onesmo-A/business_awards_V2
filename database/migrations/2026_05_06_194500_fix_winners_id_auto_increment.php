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

        $idColumn = DB::selectOne("
            SELECT EXTRA, COLUMN_KEY
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'winners'
              AND COLUMN_NAME = 'id'
            LIMIT 1
        ");

        if (! $idColumn) {
            return;
        }

        $hasPrimaryOnId = strtoupper((string) $idColumn->COLUMN_KEY) === 'PRI';
        $isAutoIncrement = stripos((string) $idColumn->EXTRA, 'auto_increment') !== false;

        if (! $hasPrimaryOnId) {
            DB::statement('ALTER TABLE `winners` ADD PRIMARY KEY (`id`)');
        }

        if (! $isAutoIncrement) {
            DB::statement('ALTER TABLE `winners` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    public function down(): void
    {
        // No-op: we intentionally do not remove AUTO_INCREMENT from primary keys.
    }
};
