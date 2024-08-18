@extends('master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Hasil Evaluasi Kehadiran</h1>
            </div>
        </section>
        <section class="content">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Evaluasi Kehadiran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIDN</th>
                                    <th>Nama Dosen</th>
                                    <th>Kode Matakuliah</th>
                                    <th>Nama Matakuliah</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                @foreach ($evaluasiupm as $evaluasi)
                                    <tr>
                                        <td >{{ $index++ }}</td>
                                        <td>{{ $evaluasi->perkuliahan->dosen->nidn }}</td>
                                        <td>{{ $evaluasi->perkuliahan->dosen->nama }}</td>
                                        <td>{{ $evaluasi->perkuliahan->matkul->kode }}</td>
                                        <td>{{ $evaluasi->perkuliahan->matkul->nama }}</td>
                                        <td>{{ $evaluasi->perkuliahan->rank->rank_upm ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('detail-evaluasi', $evaluasi->perkuliahan->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
