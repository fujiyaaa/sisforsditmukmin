@extends('layouts.app')

@section('content')

<div class="bg-white rounded-2xl shadow-lg p-8">

    <div class="flex justify-between items-start mb-8">
        <div>
            <p class="text-sm text-gray-500">Nomor Induk</p>
            <h2 class="text-2xl font-bold text-[#2F6F4F]">{{ $siswa->nis }}</h2>
        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Kelas</p>
            <h2 class="text-xl font-bold">{{ $siswa->kelas->nama_kelas ?? $siswa->kelas }}</h2>

            <p class="text-sm text-gray-500 mt-4">Nama Siswa</p>
            <h2 class="text-xl font-bold">{{ $siswa->nama }}</h2>
        </div>
    </div>

    <form action="{{ route('monitoring.store', $siswa->nis) }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block mb-2 font-semibold">Surah</label>
                <input type="text"
                       name="surah"
                       placeholder="Contoh: Al-Baqarah"
                       value="{{ old('surah') }}"
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

            <div>
                <label class="block mb-2 font-semibold">Juz (1-30)</label>
                <input type="number"
                       name="juz"
                       min="1"
                       max="30"
                       placeholder="Contoh: 30"
                       value="{{ old('juz') }}"
                       class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
            </div>

        </div>

        <div>
            <label class="block mb-3 font-semibold">Jenis Setoran</label>

            <div class="flex gap-6 flex-wrap">
                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis" value="tilawah">
                    <span>Tilawah</span>
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis" value="tahfidz">
                    <span>Tahfidz</span>
                </label>

                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis" value="murajaah">
                    <span>Murajaah</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block mb-2 font-semibold">Nilai (0-100)</label>
            <input type="number"
                   name="nilai"
                   min="0"
                   max="100"
                   placeholder="Contoh: 85"
                   value="{{ old('nilai') }}"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">
        </div>

        <div>
            <label class="block mb-2 font-semibold">Catatan Guru (Opsional)</label>
            <textarea name="keterangan"
                      rows="4"
                      placeholder="Contoh: Tartil baik, suara merdu, perlu latihan ayat 5-7"
                      class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4D9A72]">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex justify-between pt-4">
            <a href="/guru/monitoring"
               class="px-6 py-3 border rounded-xl hover:bg-gray-100 transition">
                Batal
            </a>

            <button type="submit"
                    class="bg-[#4D9A72] text-white px-6 py-3 rounded-xl hover:bg-[#2F6F4F] transition">
                💾 Simpan Setoran
            </button>
        </div>

    </form>

</div>
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
