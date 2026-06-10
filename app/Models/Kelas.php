<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\User;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
    ];

    
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }


    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }


    public function guruPengampu()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'guru_id')
            ->withTimestamps();
    }


    public function gurus()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'guru_id')
            ->withTimestamps();
    }
}
