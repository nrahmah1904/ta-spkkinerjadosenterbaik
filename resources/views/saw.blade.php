@extends('master')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="text-center">Hasil Perhitungan</h5>
                <a href="{{ url('laporan') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Laporan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>NIDN</th>
                                <th>Dosen</th>
                                <th>Matakuliah</th>
                                <th>Kode Matakuliah</th>
                                <th>Hasil</th>
                                <th>Penilaian Mahasiswa</th>
                                <th>Penilaian UPM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRank as $index => $rank)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rank->nidn }}</td>
                                <td>{{ $rank->nama }} {{ $rank->gelar }}</td>
                                <td>{{ $rank->nama_matakuliah }}</td>
                                <td>{{ $rank->kode }}</td>
                                <td>{{ number_format($rank->rank, 2) }}</td>
                                <td>{{ number_format($rank->rank_mhs, 2) }}</td>
                                <td>{{ number_format($rank->rank_upm, 2) }}</td>
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