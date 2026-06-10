<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE monitoring_sholats MODIFY sumber ENUM('guru', 'orangtua', 'admin') NOT NULL DEFAULT 'guru'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE monitoring_sholats MODIFY sumber ENUM('guru', 'orangtua') NOT NULL DEFAULT 'guru'");
    }
};
