<h4>{{ $siswa->nama }}</h4>

<form method="POST" action="/guru/monitoring">
@csrf

<input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

<input type="text" name="surah" placeholder="Surah">
<input type="number" name="juz" placeholder="Juz">

<select name="jenis">
<option value="tahfidz">Tahfidz</option>
<option value="murajaah">Murajaah</option>
<option value="tilawah">Tilawah</option>
</select>

<input type="number" name="nilai" placeholder="Nilai">

<textarea name="keterangan"></textarea>

<button>Simpan</button>
</form>
