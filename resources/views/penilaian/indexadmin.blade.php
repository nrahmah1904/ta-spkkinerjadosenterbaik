@extends('master')
@section('content')
<div class="content-wrapper mb-4 pb-4">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>
    <section class="content mb-4 pb-4">
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
                <h6 class="m-0 font-weight-bold text-primary">Data Hasil Pemberian Nilai</h6>
                <a href="{{ route('penilaian.index-per-dosen') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar
                    Dosen</a>
            </div>
            <div class="card-body">
                <b>
                    <p>NIDN : {{ $dosen->nidn }}</p>
                    <p>Nama Dosen : {{ $dosen->nama }}</p>
                </b>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Penilaian EDOM</th>
                                <th>Penilaian UPM</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                            @php
                            $perkuliahan = $item['perkuliahan'];
                            $rank = $item['rank'];
                            $penilaianEDOM = $item['jumlahMahasiswaMemilih'] > 0 ? '<a
                                href="'.route('penilaian.show', $perkuliahan->id).'"
                                class="btn btn-warning btn-sm">Lihat</a>' : 'Penilaian belum tersedia';
                            $penilaianUPM = $item['jumlahMahasiswaMemilih'] > 0 ? '<a
                                href="'.route('detail-evaluasi', $perkuliahan->id).'"
                                class="btn btn-info btn-sm">Detail</a>' : 'Penilaian belum tersedia';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $perkuliahan->matkul->kode }}</td>
                                <td>{{ $perkuliahan->matkul->nama }}</td>
                                <td>{!! $penilaianEDOM !!}</td>
                                <td>{!! $penilaianUPM !!}</td>
                                <td>{{ number_format($rank, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Hasil Pemberian Nilai</h6>
            </div>
            <div class="card-body">
                <canvas id="nilaiChart"></canvas>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('nilaiChart').getContext('2d');
    const data = @json($data);

    const labels = data.map(item => item.perkuliahan.matkul.nama);
    const nilai = data.map(item => item.rank);

    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Nilai Per Mata Kuliah',
            data: nilai,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 10 // Ubah ukuran font label pada sumbu x
                        },
                        maxRotation: 45, // Ubah rotasi maksimal label pada sumbu x
                        minRotation: 0 // Ubah rotasi minimal label pada sumbu x
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@stop