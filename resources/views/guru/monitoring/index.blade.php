@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-body">

            <h3 class="mb-4">Data Siswa Monitoring Quran</h3>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>
                            <a href="{{ url('/guru/monitoring/' . $siswa->nis) }}"
                               class="btn btn-success btn-sm">
                                Input Setoran
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
