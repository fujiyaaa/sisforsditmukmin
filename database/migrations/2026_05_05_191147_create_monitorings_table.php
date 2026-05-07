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
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();

            // Relasi ke siswa
            $table->foreignId('siswa_id')
                  ->constrained('siswas')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Jika nanti ingin tahu guru penginput
            $table->foreignId('guru_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            // Jenis setoran
            $table->enum('jenis', ['tahfidz', 'murajaah', 'tilawah']);

            // Detail hafalan
            $table->string('surah');
            $table->unsignedTinyInteger('juz')->nullable();

            // Rentang ayat
            $table->unsignedSmallInteger('ayat_dari')->nullable();
            $table->unsignedSmallInteger('ayat_sampai')->nullable();

            // Penilaian
            $table->unsignedTinyInteger('nilai')->nullable();

            // Catatan guru
            $table->text('keterangan')->nullable();

            // Tanggal setoran
            $table->date('tanggal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};