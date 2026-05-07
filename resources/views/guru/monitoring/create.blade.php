@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

                <div>
                    <small class="text-muted">Nomor Induk</small>
                    <h5 class="text-success fw-bold mb-0">
                        {{ $siswa->nis }}
                    </h5>
                </div>

                <div class="text-end">
                    <small class="text-muted">Kelas</small>
                    <h5 class="mb-0">
                        {{ $siswa->kelas->nama_kelas }}
                    </h5>
                </div>

                <div class="text-end">
                    <small class="text-muted">Nama Siswa</small>
                    <h5 class="mb-0">
                        {{ $siswa->nama }}
                    </h5>
                </div>

            </div>

            <!-- FORM -->
            <form action="{{ route('monitoring.store', $siswa->nis) }}"
                  method="POST">

                @csrf

                <input type="hidden"
                       name="siswa_id"
                       value="{{ $siswa->id }}">

                <!-- ROW -->
                <div class="row">

                    <!-- SURAH -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Surah
                        </label>

                        <input type="text"
                               name="surah"
                               class="form-control @error('surah') is-invalid @enderror"
                               placeholder="Contoh: Al-Baqarah"
                               value="{{ old('surah') }}">

                        @error('surah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- JUZ -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Juz (1-30)
                        </label>

                        <input type="number"
                               name="juz"
                               class="form-control @error('juz') is-invalid @enderror"
                               placeholder="Contoh: 30"
                               min="1"
                               max="30"
                               value="{{ old('juz') }}">

                        @error('juz')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <!-- JENIS -->
                <div class="mb-4">

                    <label class="form-label fw-semibold d-block mb-3">
                        Jenis Setoran
                    </label>

                    <div class="d-flex gap-4 flex-wrap">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="radio"
                                   name="jenis"
                                   value="tilawah"
                                   id="tilawah"
                                   {{ old('jenis') == 'tilawah' ? 'checked' : '' }}>

                            <label class="form-check-label"
                                   for="tilawah">

                                Tilawah

                            </label>

                        </div>

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="radio"
                                   name="jenis"
                                   value="tahfidz"
                                   id="tahfidz"
                                   {{ old('jenis') == 'tahfidz' ? 'checked' : '' }}>

                            <label class="form-check-label"
                                   for="tahfidz">

                                Tahfidz

                            </label>

                        </div>

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="radio"
                                   name="jenis"
                                   value="murajaah"
                                   id="murajaah"
                                   {{ old('jenis') == 'murajaah' ? 'checked' : '' }}>

                            <label class="form-check-label"
                                   for="murajaah">

                                Murajaah

                            </label>

                        </div>

                    </div>

                    @error('jenis')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- NILAI -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nilai (0-100)
                    </label>

                    <input type="number"
                           name="nilai"
                           class="form-control @error('nilai') is-invalid @enderror"
                           placeholder="Contoh: 85"
                           min="0"
                           max="100"
                           value="{{ old('nilai') }}">

                    @error('nilai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- KETERANGAN -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Catatan Guru (Opsional)
                    </label>

                    <textarea name="keterangan"
                              rows="4"
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Contoh: Tartil baik, perlu latihan ayat tertentu">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">

                    <a href="/guru/monitoring"
                       class="btn btn-outline-secondary px-4">

                        Batal

                    </a>

                    <button type="submit"
                            class="btn btn-success px-4">

                        💾 Simpan Setoran

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<!-- ================== SWEET ALERT ================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '<strong>Berhasil Disimpan</strong>',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#28a745',
            timer: 3500,
            timerProgressBar: true,
            position: 'center',
            width: '500px',
            padding: '2.5rem',
            backdrop: `
                rgba(0,0,0,0.6)
            `
        });
    });
</script>
@endif
@endsection
