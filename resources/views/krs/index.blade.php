@extends('master')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Daftar KRS</h1>
            </div>
        </section>

        <section class="content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Krs</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Semester</th>
                                            <th>Status Validasi</th>
                                            <th>Perkuliahan</th>
                                            @if (auth()->user()->level == 'Admin')
                                                <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($krsEntries as $krs)
                                            <tr>
                                                <td>{{ $krs->mahasiswa->nama }}</td>
                                                <td>{{ $krs->mahasiswa->nim }}</td>
                                                <td>{{ $krs->tahunAjaran->tahun_ajaran }}</td>
                                                <td>{{ $krs->semester }}</td>
                                                <td>{{ $krs->is_validated ? 'Tervalidasi' : 'Belum Validasi' }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($krs->detail as $detail)
                                                            <li>{{ $detail->perkuliahan->matkul->nama }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                @if (auth()->user()->level == 'Admin')
                                                    <td>
                                                        @if (!$krs->is_validated)
                                                            <form action="{{ route('krs.validate', $krs->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-success">Validasi</button>
                                                            </form>
                                                        @else
                                                            Tervalidasi oleh {{ $krs->validator->name }}
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
@endsection
