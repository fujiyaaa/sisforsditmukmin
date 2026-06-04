<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan index biasa untuk foreign key siswa_id
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->index('siswa_id', 'monitoring_sholats_siswa_id_idx');
        });

        // Hapus unique lama siswa_id + tanggal
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->dropUnique('monitoring_sholats_siswa_id_tanggal_unique');
        });

        // Tambahkan unique baru siswa_id + tanggal + sumber
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->unique(
                ['siswa_id', 'tanggal', 'sumber'],
                'monitoring_sholats_siswa_tanggal_sumber_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->dropUnique('monitoring_sholats_siswa_tanggal_sumber_unique');
        });

        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->unique(
                ['siswa_id', 'tanggal'],
                'monitoring_sholats_siswa_id_tanggal_unique'
            );
        });

        Schema::table('monitoring_sholats', function (Blueprint $table) {
            $table->dropIndex('monitoring_sholats_siswa_id_idx');
        });
    }
};