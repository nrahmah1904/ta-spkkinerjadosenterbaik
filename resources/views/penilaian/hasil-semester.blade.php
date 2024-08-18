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
                <h6 class="m-0 font-weight-bold text-primary">Hasil Penilaian Semester {{ $semester }}</h6>
                <div class="mb-4">
           
                </div>
                <a class="btn btn-primary" href="{{ route('penilaian.indexadmin.semester') }}">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="donutChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3">
                            <p>Total Mahasiswa: {{ $totalMahasiswa }}</p>
                            <p>Sudah Menilai: {{ $totalPenilai }}</p>
                            <p>Belum Menilai: {{ $totalBelumMenilai }}</p>
                            <a href="{{ route('penilaian.admin.tabel.hasil.semester', $semester) }}" class="btn btn-primary">Lihat Tabel Hasil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donutChart').getContext('2d');
    const data = {
        labels: ['Sudah Menilai', 'Belum Menilai'],
        datasets: [{
            data: [{{ $totalPenilai }}, {{ $totalMahasiswa - $totalPenilai }}],
            backgroundColor: ['#4e73df', '#e74a3b'],
        }]
    };

    const donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@stop
@endsection
