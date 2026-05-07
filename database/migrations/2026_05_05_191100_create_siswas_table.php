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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            // Data utama siswa
            $table->string('nis')->unique();
            $table->string('nama');

            // Biodata
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Kontak & alamat
            $table->text('alamat')->nullable();

            // Akademik
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');

            // Relasi orang tua (users.id)
            $table->unsignedBigInteger('orangtua_id')->nullable();

            // Tambahan
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();

            // Foreign key
            $table->foreign('orangtua_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
