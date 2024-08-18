@extends('master')
@section('content')
@extends('master')
@section('content')
<style>
#form1 {
    border-width: 2px;
    border-left-color: #6495ED;
    border-right-color: #6495ED;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Matakuliah</h6>
                <div class="mb-4"></div>
                <a href="/matakuliah" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <form action="{{ url('/matakuliah/update/'.$matakuliah->kode) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Mata Kuliah</label>
                            <input type="text" id="form1" class="form-control" name="kode"
                                value="{{ $matakuliah->kode }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Mata Kuliah</label>
                            <input type="text" id="form1" class="form-control" name="nama"
                                value="{{ $matakuliah->nama }}">
                        </div>
                        <div class="form-group">
                            <label>Jumlah SKS</label>
                            <input type="text" id="form1" class="form-control" name="sks"
                                value="{{ $matakuliah->sks }}">
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" id="form1" class="form-control" name="smt"
                                value="{{ $matakuliah->smt }}">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection