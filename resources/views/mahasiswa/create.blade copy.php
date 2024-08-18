@include('master')
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
                <h5 class="text-center">Tambah Data Mahasiswa</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <form action="/mahasiswa/store" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input id="form1" type="text" class="form-control" name="nama">
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input id="form1" type="text" class="form-control" name="tempatlahir"
                                placeholder="Masukkan Tempat Lahir">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input id="form1" type="date" class="form-control" name="tanggallahir"
                                placeholder="Masukkan Tanggal Lahir">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="form1" type="email" class="form-control" name="email"
                                placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label>Kata Sandi</label>
                            <input id="form1" type="password" class="form-control" name="password"
                                placeholder="Masukkan Kata Sandi">
                        </div>
                        <div class="card-footer" style="background-color: white;"><br>
                            <input type="submit" name="submit" class="btn btn-info"></input>
                        </div>
                </div>
                </form>
    </section>
</div>