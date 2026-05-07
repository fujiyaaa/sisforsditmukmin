@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0">
        <div class="card-body">

            <!-- HEADER -->
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <small class="text-muted">Nomor Induk</small><br>
                    <h5 class="text-success">{{ $siswa->nis }}</h5>
                </div>
                <div class="text-end">
                    <small class="text-muted">Kelas</small><br>
                    <h5>{{ $siswa->kelas }}</h5>
                </div>
                <div class="text-end">
                    <small class="text-muted">Nama Siswa</small><br>
                    <h5>{{ $siswa->nama }}</h5>
                </div>
            </div>


            <form action="{{ url('/guru/monitoring/' . $siswa->nis) }}" method="POST">
                @csrf

                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                <!-- ROW 1 -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Surah</label>
                        <input type="text" name="surah"
                            class="form-control @error('surah') is-invalid @enderror"
                            placeholder="Contoh: Al-Baqarah"
                            value="{{ old('surah') }}">

                        @error('surah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Juz (1-30)</label>
                        <input type="number" name="juz"
                            class="form-control @error('juz') is-invalid @enderror"
                            placeholder="Contoh: 30"
                            min="1" max="30"
                            value="{{ old('juz') }}">

                        @error('juz')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- JENIS -->
                <div class="mb-3">
                    <label class="form-label">Jenis Setoran</label><br>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('jenis') is-invalid @enderror"
                            type="radio" name="jenis" value="tilawah"
                            {{ old('jenis') == 'tilawah' ? 'checked' : '' }}>
                        <label class="form-check-label">Tilawah</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                            type="radio" name="jenis" value="tahfidz"
                            {{ old('jenis') == 'tahfidz' ? 'checked' : '' }}>
                        <label class="form-check-label">Tahfidz</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                            type="radio" name="jenis" value="murajaah"
                            {{ old('jenis') == 'murajaah' ? 'checked' : '' }}>
                        <label class="form-check-label">Murajaah</label>
                    </div>

                    @error('jenis')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NILAI -->
                <div class="mb-3">
                    <label class="form-label">Nilai (0-100)</label>
                    <input type="number" name="nilai"
                        class="form-control @error('nilai') is-invalid @enderror"
                        placeholder="Contoh: 85"
                        min="0" max="100"
                        value="{{ old('nilai') }}">

                    @error('nilai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CATATAN -->
                <div class="mb-4">
                    <label class="form-label">Catatan Guru (Opsional)</label>
                    <textarea name="keterangan"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        rows="3"
                        placeholder="Contoh: Tartil baik, suara merdu, perlu latihan ayat 5-7">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="/guru/siswa" class="btn btn-outline-secondary px-4">
                        Batal
                    </a>

                    <button class="btn btn-success px-4">
                        💾 Simpan Setoran
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
