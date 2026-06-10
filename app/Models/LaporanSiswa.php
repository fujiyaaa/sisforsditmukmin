<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanSiswa extends Model
{
     protected $table = 'laporan_siswas';

    protected $fillable = [
        'siswa_id',
        'jenis',
        'judul',
        'deskripsi',
        'tanggal',
        'tingkat',
        'catatan',
        'sertifikat',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
