@include('master')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Data Mata Kuliah</h5>
            </div>

            <div class="card-body">
                <a href="/matkul/create" class="btn btn-primary">Tambah Data</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($matkul as $index=>$s)
                    <tbody>
                        <tr>
                            <td>{{$index + $matkul->firstitem()}}</td>
                            <td>{{$s->kode}}</td>
                            <td>{{$s->nama}}</td>
                            <td>{{$s->sks}}</td>
                            <td>{{$s->smt}}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="/matkul/{{$s->id}}/edit">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <div class="cart-footer">{{ $matkul->links() }}</div>
            </div>
        </div>
    </section>
</div>