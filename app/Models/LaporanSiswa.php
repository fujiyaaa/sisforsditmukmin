<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanSiswa extends Model
{
    protected $fillable = [
        'siswa_id',
        'jenis',
        'judul',
        'deskripsi',
        'tanggal',
        'tingkat',
        'catatan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
