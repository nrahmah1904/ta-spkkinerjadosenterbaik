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
        
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Data Hasil Pemberian Nilai</h5>
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
                            <th>List Jawaban Mahasiswa</th>
                            <th>Penilaian UPM</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($penilaian as $e=>$s)
                        <tr>
                            <td>{{$e+1}}</td>
                            <td>{{$s->id_dosen}}</td>
                            <td>{{$s->nama_dosen}}</td>
                            <td>{{$s->gelar}}</td>
                            <td align="center"><a class="btn btn-sm btn-warning" href="/nilai/{{$s->dosen_id}}/show">Lihat</a>
                            </td>
                            <td align="center">
                                @php
                                $tot_jawaban=0;
                                $no=1;
                                $hasil_admin = DB::table('evaluasiupm')
                                ->join('dosen', 'dosen.id', '=', 'evaluasiupm.id_dosen')
                                ->where('id_dosen', $s->id_dosen)
                                ->get();
                                @endphp
                                @php
                                if ($hasil_admin->count()==0){
                                @endphp
                                <a class="btn btn-sm btn-primary" href="/nilai/{{$s->dosen_id}}/proses">Penilaian
                                    Selanjutnya</a>
                                @php
                                }else{
                                @endphp
                                <a class="btn btn-sm btn-danger" href="/nilai/{{$s->dosen_id}}/proses">Lihat Hasil
                                    Penilaian</a>
                                @php
                                }
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('periode-penilaian-selesai') }}" method="post" id="periode-penilaian-form" class="float-right mt-2" style="display: {{ $tahunAjaranAktif ? 'inline-block' : 'none' }}">
                    @csrf
                    <button type="button" class="btn btn-success" onclick="confirmSelesai()">Periode Penilaian Selesai</button>
                </form>
            </div>
        </div>
    </section>
</div>
@section('js')
<script>
function confirmSelesai() {
    if (confirm('Apakah Anda yakin ingin mengakhiri periode penilaian?')) {
        document.getElementById('periode-penilaian-form').submit();
    }
}
</script>
@stop

@endsection