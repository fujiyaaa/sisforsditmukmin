@extends('layouts.app')

@section('title', 'Monitoring Setoran Qur\'an')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg,#198754,#20c997); color:white;">
        <div class="card-body">
            <h3 class="mb-1">Assalamu'alaikum, Bapak/Ibu Orang Tua</h3>
            <p class="mb-0">
                Monitoring Hafalan Ananda :
                <strong>{{ $siswa->nama }}</strong>
                | Kelas  {{ $siswa->kelas->nama_kelas }}
            </p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Total Setoran</small>
                    <h2 class="fw-bold text-success">{{ $totalSetoran }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Tahfidz</small>
                    <h2 class="fw-bold text-primary">{{ $totalTahfidz }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Tilawah</small>
                    <h2 class="fw-bold text-warning">{{ $totalTilawah }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted">Rata-rata Nilai</small>
                    <h2 class="fw-bold text-danger">
                        {{ round($rataNilai ?? 0) }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        {{-- Riwayat Setoran --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Riwayat Setoran Terbaru</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Surah</th>
                                    <th>Juz</th>
                                    <th>Nilai</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($monitorings as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>

                                    <td>
                                        @if($item->jenis == 'tahfidz')
                                            <span class="badge bg-success">Tahfidz</span>
                                        @elseif($item->jenis == 'murajaah')
                                            <span class="badge bg-primary">Murajaah</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Tilawah</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->surah }}</td>
                                    <td>{{ $item->juz }}</td>
                                    <td>{{ $item->nilai ?? '-' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data monitoring.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Progress --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Progress Hafalan</h5>
                </div>

                <div class="card-body">

                    <label class="mb-1">Juz 30</label>
                    <div class="progress mb-3" style="height:10px;">
                        <div class="progress-bar bg-success" style="width:75%"></div>
                    </div>

                    <label class="mb-1">Juz 29</label>
                    <div class="progress mb-3" style="height:10px;">
                        <div class="progress-bar bg-info" style="width:45%"></div>
                    </div>

                    <label class="mb-1">Juz 28</label>
                    <div class="progress" style="height:10px;">
                        <div class="progress-bar bg-warning" style="width:20%"></div>
                    </div>

                </div>
            </div>

            {{-- Catatan --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Catatan Guru</h5>
                </div>

                <div class="card-body">
                    @if($monitorings->count())
                        {{ $monitorings->first()->keterangan ?? 'Tidak ada catatan.' }}
                    @else
                        Tidak ada catatan.
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
