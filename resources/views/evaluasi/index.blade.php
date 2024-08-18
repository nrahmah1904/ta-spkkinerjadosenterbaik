@extends('master')
@section('content')
    <!-- End of Topbar -->
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

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Evaluasi Kehadiran Dosen</h6>
                <div class="mb-4"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kelas</th>
                                <th>Dosen</th>
                                <th>Tahun Ajaran</th>
                                <th>Mata Kuliah</th>
                                <th>Semester</th>
                                <th>Penilaian UPM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perkuliahans as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>{{ $item->dosen->nama }}</td>
                                    <td>{{ $item->tahunAjaran->tahun_ajaran }} {{ $item->tahunAjaran->ganjil_genap }}</td>
                                    <td>{{ $item->matkul->nama }}</td>
                                    <td>{{ $item->matkul->smt }}</td>
                                    <td>
                                        <a href="{{ route('evaluasi.beri-nilai', $item->id) }}" class="btn btn-dark btn-sm">Beri Nilai</a>
                                       
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
    <!-- End of Topbar -->
@endsection
