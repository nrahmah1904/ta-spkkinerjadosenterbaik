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
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="card shadow mb-4">
            <!-- Main content -->
            <section class="content">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Skala Nilai</h6>
                    <div class="mb-4"></div>
                    <a href="/" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kriteria</th>
                                <th>Sub Kriteria</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skalanilai as $e=>$s)
                            <tr>
                                <td>{{$e+1}}</td>
                                <td>{{ $s->kriteria }}</td>
                                <td>{{$s->subkriteria}}</td>
                                <td>{{$s->nilai}}</td>
                                <td><button class="btn btn-primary btn-circle btn-sm"><i
                                            class="fas fa-edit"></i></button></a>
                                    <button class="btn btn-danger btn-circle btn-sm" href="/dosen" input type="submit"
                                        value="Delete"><i class="fas fa-trash"></i></button>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </section>
</div>
@endsection