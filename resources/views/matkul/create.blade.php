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
                <h5 class="text-center">Tambah Data Mata Kuliah</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <form action="/matkul/store" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kode Mata Kuliah</label>
                            <input id="form1" type="text" class="form-control" name="kode">
                        </div>
                        <div class="form-group">
                            <label>Nama Mata Kuliah</label>
                            <input id="form1" type="text" class="form-control" name="nama" placeholder="Masukkan Nama Mata Kuliah">
                        </div>
                        <div class="form-group">
                            <label>Jumlah SKS</label>
                            <input id="form1" type="text" class="form-control" name="sks"
                                placeholder="Masukkan Jumlah SKS">
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input id="form1" type="text" class="form-control" name="smt"
                                placeholder="Masukkan Semester">
                        </div>
                        <div class="card-footer" style="background-color: white;"><br>
                            <input type="submit" name="submit" class="btn btn-info"></input>
                        </div>
                </div>
                </form>
    </section>
</div>