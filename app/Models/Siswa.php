<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nis', 'nama', 'kelas_id'];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
