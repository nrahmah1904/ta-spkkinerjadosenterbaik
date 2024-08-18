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
                <h5 class="text-center">Edit Data Kriteria</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <form action="/kriteria/{{$kriteria->id}}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label>Kode</label>
                            <input id="form1" type="text" class="form-control" name="kode" value="{{$kriteria->kode}}">
                        </div>
                        <div class="form-group">
                            <label>Kriteria</label>
                            <input id="form1" type="text" class="form-control" name="kriteria"
                                placeholder="Masukkan Kriteria" value="{{$kriteria->kriteria}}">
                        </div>
                        <div class="form-group">
                            <label>Bobot</label>
                            <input id="form1" type="text" class="form-control" name="bobot"
                                placeholder="Masukkan NIlai Bobot" value="{{$kriteria->bobot}}">
                        </div>
                        <div class="form-group">
                            <label>Bobot (Desimal)</label>
                            <input id="form1" type="text" class="form-control" name="desimal"
                                placeholder="Masukkan Bobot Desimal" value="{{$kriteria->desimal}}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input id="form1" type="text" class="form-control" name="status"
                                placeholder="Masukkan Status Kriteria" value="{{$kriteria->status}}">
                        </div>
                        <div class="form-group">
                            <label>Pengguna</label>
                            <select class="form-control select2" name="pengguna" id="pengguna">
                                <option value="">Pilih Pengguna</option>
                                <option value="Mahasiswa" @php if($kriteria->pengguna == 'Mahasiswa') { echo "selected=''"; } @endphp>Mahasiswa</option>
                                <option value="Admin" @php if($kriteria->pengguna == 'Admin') { echo "selected=''"; } @endphp>Admin</option>
                            </select>
                        </div>
                        <div class="card-footer" style="background-color: white;"><br>
                            <input type="submit" name="submit" class="btn btn-info"></input>
                        </div>
                </div>
                </form>
    </section>
</div>