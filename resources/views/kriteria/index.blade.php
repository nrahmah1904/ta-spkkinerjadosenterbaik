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
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Kriteria</h6>
                <div class="mb-4"></div>
                <a href="/kriteria/create" class="btn btn-primary">Tambah</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="example2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>Bobot(Desimal)</th>
                            <th>Status</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        @foreach($kriteria as $e=>$s)
                        <tr>
                            <td>{{$e+1}}</td>
                            <td>{{$s->kode}}</td>
                            <td>{{$s->kriteria}}</td>
                            <td>{{$s->bobot}}</td>
                            <td>{{$s->desimal}}</td>
                            <td>{{$s->status}}</td>
                            <td>{{$s->pengguna}}</td>
                            <td>
                                <a href="/kriteria/{{$s->id}}/edit"><button class="btn btn-primary btn-circle btn-sm"><i
                                            class="fas fa-edit"></i></button></a>
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