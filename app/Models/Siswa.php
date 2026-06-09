<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LaporanSiswa;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'kelas_id'];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function monitoringSholat()
    {
        return $this->hasMany(MonitoringSholat::class);
    }

    public function laporanSiswas()
    {
        return $this->hasMany(LaporanSiswa::class);
    }
    public function orangtua()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }
}
