<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LaporanSiswa;
use App\Models\Monitoring;
use App\Models\MonitoringSholat;
use App\Models\Kelas;
use App\Models\User;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kelas_id',
        'orangtua_id',
    ];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function monitoringSholat()
    {
        return $this->hasMany(MonitoringSholat::class, 'siswa_id');
    }

    public function laporanSiswas()
    {
        return $this->hasMany(LaporanSiswa::class, 'siswa_id');
    }

    public function orangtua()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }
}
