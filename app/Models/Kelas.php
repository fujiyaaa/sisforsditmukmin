<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    public function gurus()
{
    return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'guru_id')
        ->withTimestamps();
}
}
