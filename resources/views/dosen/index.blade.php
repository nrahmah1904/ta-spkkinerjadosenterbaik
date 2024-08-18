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
                <h6 class="m-0 font-weight-bold text-primary">Data Dosen</h6>
                <div class="mb-4"></div>
                <a href="/dosen/create" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Tambah</span>
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="example2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama Dosen</th>
                            <th>Gelar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        @foreach ($dosen as $e => $a)
                        <tr>
                            <td>{{ $e + 1 }}</td>
                            <td>{{ $a->nidn }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->gelar }}</td>
                            <td>
                                <a href="/dosen/{{ $a->nidn }}/edit"><button
                                        class="btn btn-primary btn-circle btn-sm"><i
                                            class="fas fa-edit"></i></button></a>
                                <form action="/dosen/{{ $a->nidn }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-circle btn-sm" href="/dosen" input type="submit"
                                        value="Delete"><i class="fas fa-trash"></i></button>
                                </form>
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