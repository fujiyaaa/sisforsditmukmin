<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru', 'orangtua'])
                    ->default('orangtua')
                    ->after('password');
            }

            if (!Schema::hasColumn('users', 'must_change_password')) {
                $table->boolean('must_change_password')
                    ->default(true)
                    ->after('role');
            }

            if (!Schema::hasColumn('users', 'siswa_id')) {
                $table->foreignId('siswa_id')
                    ->nullable()
                    ->after('must_change_password')
                    ->constrained('siswas')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'siswa_id')) {
                $table->dropConstrainedForeignId('siswa_id');
            }

            if (Schema::hasColumn('users', 'must_change_password')) {
                $table->dropColumn('must_change_password');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
