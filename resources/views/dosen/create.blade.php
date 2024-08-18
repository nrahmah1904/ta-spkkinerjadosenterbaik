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
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data Dosen</h6>
                <div class="mb-4"></div>
                <a href="/dosen" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <form action="/dosen/store" method="post">
                        @csrf
                        <div class="form-group">
                            <label>NIDN</label>
                            <input id="form1" type="text" class="form-control" name="nidn">
                        </div>
                        <div class="form-group">
                            <label>Nama Dosen</label>
                            <input id="form1" type="text" class="form-control" name="nama"
                                placeholder="Masukkan Nama Dosen">
                        </div>
                        <div class="form-group">
                            <label>Gelar</label>
                            <input id="form1" type="text" class="form-control" name="gelar"
                                placeholder="Masukkan Gelar Dosen">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary"></input>
                        </div>
                </div>
            </div>
            </form>
    </section>
</div>
@endsection