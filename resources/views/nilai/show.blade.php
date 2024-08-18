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
                <h5 class="text-center">Lihat Data Penilaian</h5>
            </div>
            <div>
                <td>
                    <a class="btn btn-sm btn-danger" href="/nilai">Kembali</a>
                </td>
            </div>
            <div class="card-body">
                {{-- <a href="/kriteria/create" class="btn btn-primary">Tambah Data</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="/nilai/store" method="post">
                    @csrf
                    <div class="form-group">
                        <label>NIDN</label>
                        <input id="form1" type="text" class="form-control" name="id_dosen"
                             value="{{$dosen->id}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Dosen</label>
                        <input id="form1" type="text" class="form-control" name="nama_dosen"
                             value="{{$dosen->nama}}" readonly>
                    </div>

                    <hr>
                    @php $index = 0; @endphp
                    @foreach($penilaian as $d=>$pen)
                    <div class="form-group">
                        <label onclick="toggleDetails({{ $index }})" style="cursor: pointer;">Mahasiswa {{$index+1}}</label>
                    </div>
                    <div id="penilaian-details-{{ $index }}" style="display: none;">
                        <div class="form-group">
                            <label>Tanggal Penilaian</label>
                            <input id="form1" type="text" class="form-control" name="tanggal_penilaian"
                                 value="{{$pen->tanggal_penilaian}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Mahasiswa</label>
                            <input id="form1" type="text" class="form-control" name="id_mahasiswa"
                                 value=" MHS {{$index+1}}" readonly>
                        </div>
                        <table class="table table-bordered" id="">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th>Pertanyaan</th>
                                    <th style="width: 5%;">1</th>
                                    <th style="width: 5%;">2</th>
                                    <th style="width: 5%;">3</th>
                                    <th style="width: 5%;">4</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px">
                                @php
                                $tot_jawaban=0;
                                $no=1;
                                $penilaian2 = DB::table('evaluasimhs')
                                ->join('kriteria', 'kriteria.id', '=', 'evaluasimhs.id_kriteria')
                                ->join('penilaian', 'penilaian.id', '=', 'evaluasimhs.id_penilaian')
                                ->where('id_penilaian', $pen->id_pen)
                                ->get();
                                @endphp
                                @foreach($penilaian2 as $e=>$bantu)
                                @php
                                $jawaban[$index]['detail'][]=$bantu->jawaban;
                                $tot_jawaban += $bantu->jawaban;
                                @endphp
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$bantu->kriteria}}</td>
                                    <td>
                                        <input id="jawaban{{ $index }}{{ $e }}" type="radio" class="form-control"
                                            name="jawaban{{ $index }}[{{$e}}]" value="1" style="width: 20px;" disabled=""
                                            @php if( $jawaban[$index]['detail'][$e]=='1' ) { echo 'checked' ; } @endphp>
                                    </td>
                                    <td>
                                        <input id="jawaban{{ $index }}{{ $e }}" type="radio" class="form-control"
                                            name="jawaban{{ $index }}[{{$e}}]" value="2" style="width: 20px;" disabled=""
                                            @php if( $jawaban[$index]['detail'][$e]=='2' ) { echo 'checked' ; } @endphp>
                                    </td>
                                    <td>
                                        <input id="jawaban{{ $index }}{{ $e }}" type="radio" class="form-control"
                                            name="jawaban{{ $index }}[{{$e}}]" value="3" style="width: 20px;" disabled=""
                                            @php if( $jawaban[$index]['detail'][$e]=='3' ) { echo 'checked' ; } @endphp>
                                    </td>
                                    <td>
                                        <input id="jawaban{{ $index }}{{ $e }}" type="radio" class="form-control"
                                            name="jawaban{{ $index }}[{{$e}}]" value="4" style="width: 20px;" disabled=""
                                            @php if( $jawaban[$index]['detail'][$e]=='4' ) { echo 'checked' ; } @endphp>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tr align="center">
                                <th colspan="2" align="center">Total Nilai</th>
                                <th colspan="4" align="center">{{$tot_jawaban}}</th>
                            </tr>
                        </table>
                    </div>
                    @php $index++; @endphp
                    @endforeach
                    <div class="card-footer" style="background-color: white;"><br>
                        {{-- <input type="submit" name="submit" class="btn btn-info"></input> --}}
                    </div>
            </div>
            </form>
        </div>
</div>
</section>
</div>

<script>
    function toggleDetails(index) {
        var detailElement = document.getElementById('penilaian-details-' + index);
        if (detailElement.style.display === 'none') {
            detailElement.style.display = 'block';
        } else {
            detailElement.style.display = 'none';
        }
    }
</script>
@endsection
