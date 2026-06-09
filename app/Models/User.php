<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'nip',
    'password',
    'role',
    'must_change_password',
    'siswa_id',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }
    public function kelasDiampu()
{
    return $this->belongsToMany(Kelas::class, 'guru_kelas', 'guru_id', 'kelas_id')
        ->withTimestamps();
}
}
