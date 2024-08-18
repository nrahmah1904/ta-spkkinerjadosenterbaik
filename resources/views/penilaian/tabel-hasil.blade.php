@extends('master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Hasil Penilaian Semester {{ $semester }}</h6>
                <a class="btn btn-primary" href="{{ route('penilaian.indexadmin.semester') }}">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama Dosen</th>
                            <th>Mata Kuliah</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        @if($dataRank->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Data Pada Periode ini tidak ada</td>
                        </tr>
                        @else
                        @foreach ($dataRank as $e => $s)
                        <tr>
                            <td>{{ $e + 1 }}</td>
                            <td>{{ $s->nidn }}</td>
                            <td>{{ $s->nama }} {{ $s->gelar }}</td>
                            <td>{{ $s->nama_matakuliah }}</td>
                            <td>{{ number_format((float) $s->rank, 2, '.', '') }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Hasil Penilaian Semester {{ $semester }}</h6>
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
    const dataRank = @json($dataRank);

    const labels = dataRank.map(item => item.nama_matakuliah + ' (' + item.nama + ')');
    const nilai = dataRank.map(item => item.rank);

    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Nilai Per Mata Kuliah',
            data: nilai,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
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