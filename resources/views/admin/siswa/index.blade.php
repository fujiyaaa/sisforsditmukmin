<form action="/admin/siswa" method="POST">
    @csrf

    <input type="text" name="nis" placeholder="NIS">

    <input type="text" name="nama" placeholder="Nama">

    <select name="kelas_id">

        <option value="">Pilih Kelas</option>

        @foreach($kelas as $k)
            <option value="{{ $k->id }}">
                {{ $k->nama_kelas }}
            </option>
        @endforeach

    </select>

    <button>Simpan</button>
</form>
