<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('monitorings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id');
        $table->string('surah');
        $table->integer('juz');
        $table->enum('jenis', ['tahfidz', 'murajaah', 'tilawah']);
        $table->integer('nilai')->nullable();
        $table->text('keterangan')->nullable();
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
