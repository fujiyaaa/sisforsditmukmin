<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $fillable = [
    'siswa_id',
    'surah',
    'juz',
    'jenis',
    'nilai',
    'keterangan',
    'tanggal'
];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
