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
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Matakuliah</h6>
                <div class="mb-4"></div>
                <a href="{{ url('/matakuliah/create') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Tambah</span>
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="example2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matakuliah as $e => $a)
                        <tr>
                            <td>{{ $e + 1 }}</td>
                            <td>{{ $a->kode }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->sks }}</td>
                            <td>{{ $a->smt }}</td>
                            <td>
                                <a href="{{ url('/matakuliah/' . $a->kode . '/edit') }}"><button
                                        class="btn btn-primary btn-circle btn-sm"><i
                                            class="fas fa-edit"></i></button></a>
                                <form action="{{ url('/matakuliah/' . $a->kode) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-circle btn-sm" href="/matakuliah" input
                                        type="submit" value="Delete" class="btn btn-primary btn-circle btn-sm"><i
                                            class="fas fa-trash"></i></button>
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