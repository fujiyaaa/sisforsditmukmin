<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->dropUnique(['siswa_id', 'tanggal']);

            $table->enum('sumber', ['guru', 'orangtua'])
                ->default('guru')
                ->after('tanggal');

            $table->unique(['siswa_id', 'tanggal', 'sumber']);
        });
    }

    public function down(): void
    {
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->dropUnique(['siswa_id', 'tanggal', 'sumber']);

            $table->dropColumn('sumber');

            $table->unique(['siswa_id', 'tanggal']);
        });
    }
};