@extends('master')
@section('content')
<style>
#form1 {
    border-width: 2px;
    border-left-color: #00CED1;
    border-right-color: #00CED1;
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
        <div class="card card-info">
            <div class="card-header md-12">
                <h5 class="text-center">Edit Data Mahasiswa</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <form action="/mahasiswa/{{$mahasiswa->nim}}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input id="form1" type="text" class="form-control" name="nama" value="{{$mahasiswa->nama}}">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input id="form1" type="text" class="form-control" name="tempatlahir"
                                placeholder="Masukkan Tempat Lahir" value="{{$mahasiswa->tempatlahir}}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input id="form1" type="date" class="form-control" name="tanggallahir"
                                placeholder="Masukkan Tanggal Lahir" value="{{$mahasiswa->tanggallahir}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="form1" type="email" class="form-control" name="email"
                                placeholder="Masukkan Email" value="{{$mahasiswa->email}}">
                        </div>
                        <div class="card-footer" style="background-color: white;"><br>
                            <input type="submit" name="submit" class="btn btn-info"></input>
                        </div>
                </div>
                </form>
    </section>
</div>
@endsection