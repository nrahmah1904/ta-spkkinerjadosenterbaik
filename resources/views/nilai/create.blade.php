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
            <div class="card card-primary">
                <div class="card-header md-12">
                    <h5 class="text-center">Input Penilaian</h5>
                </div>

                <div class="card-body">
                    {{-- <a href="/kriteria/create" class="btn btn-primary">Tambah Data</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="/nilai/store" method="post">
                        @csrf
                        @php
                            $jumlah_data1 = DB::table('penilaian')->get();
                            $jumlah_data2 = DB::table('evaluasiupm')->get();
                            $table_no = '0001'; // nantinya menggunakan database dan table sungguhan
                            $tgl = substr(str_replace('-', '', Carbon\carbon::now()), 0, 8);
                            $no = $tgl . $table_no;
                            $auto = substr($no, 8);
                            $auto = intval($auto) + $jumlah_data1->count() + $jumlah_data2->count();
                            $auto_number = str_repeat(0, 4 - strlen($auto)) . $auto;
                        @endphp
                        <input  type="hidden" class="form-control" name="tanggal_penilaian"
                            placeholder="Masukkan ID Kriteria" value="@php echo date('Y-m-d'); @endphp">
                        <input  type="hidden" class="form-control" name="id"
                            placeholder="Masukkan ID Kriteria" value="@php echo $auto_number; @endphp">
                        {{-- <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                                value="{{ $tahunAjaranAktif->tahun_ajaran }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="ganjil_genap">Semester</label>
                            <input type="text" class="form-control" id="ganjil_genap" name="ganjil_genap"
                                value="{{ $tahunAjaranAktif->ganjil_genap }}" readonly>
                        </div> --}}

                        <div class="form-group">
                            <label for="semester">Pilih Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                @if ($tahunAjaranAktif->ganjil_genap == 'Ganjil')
                                    <option value="1">Semester 1</option>
                                    <option value="3">Semester 3</option>
                                    <option value="5">Semester 5</option>
                                    <option value="7">Semester 7</option>
                                @else
                                    <option value="2">Semester 2</option>
                                    <option value="4">Semester 4</option>
                                    <option value="6">Semester 6</option>
                                    <option value="8">Semester 8</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                                <input  type="hidden" class="form-control" id="id_mahasiswa" name="id_mahasiswa" value="{{ $mahasiswa->id }}">
                            <label>Dosen</label>
                            <select class="form-control select2" name="id_dosencari" id="id_dosencari" required>
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosen as $e => $m)
                                    <option value="{{ $m->nidn }}" data-id="{{ $m->id }}">{{ $m->nama }} {{ $m->gelar }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <input type="hidden" name="id_dosen" id="id_dosen"> --}}
                        {{-- <input type="hidden" name="perkuliahan_id" id="perkuliahan_id"> --}}

                        <div class="form-group">
                            <label>Mata Kuliah</label>
                            <select class="form-control select2" name="perkuliahan_id" id="perkuliahan_id" required>
                                <option value="">Pilih Mata Kuliah - Semester</option>
                            </select>
                        </div>
                        <table class="table table-bordered">
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
                                @foreach ($kriteria as $e => $s)
                                    <tr>
                                        <input  type="hidden" class="form-control" name="id_kriteria[]"
                                            placeholder="Masukkan ID Kriteria" value="{{ $s->id }}">
                                        <td>{{ $e + 1 }}</td>
                                        <td>{{ $s->kriteria }}</td>
                                        <td>
                                            <input id="jawaban{{ $e }}" type="radio" class="form-control"
                                                name="jawaban[{{ $e }}]" value="1" style="width: 20px;">
                                        </td>
                                        <td>
                                            <input id="jawaban{{ $e }}" type="radio" class="form-control"
                                                name="jawaban[{{ $e }}]" value="2" style="width: 20px;">
                                        </td>
                                        <td>
                                            <input id="jawaban{{ $e }}" type="radio" class="form-control"
                                                name="jawaban[{{ $e }}]" value="3" style="width: 20px;">
                                        </td>
                                        <td>
                                            <input id="jawaban{{ $e }}" type="radio" class="form-control"
                                                name="jawaban[{{ $e }}]" value="4" style="width: 20px;">
                                        </td>
                                    </tr>
                                    <input  type="hidden" class="form-control" name="pengguna[]"
                                        placeholder="Masukkan ID Kriteria" value="{{ $s->pengguna }}">
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer" style="background-color: white;"><br>
                            <input type="submit" name="submit" class="btn btn-info"></input>
                        </div>
                </div>
                </form>
            </div>
    </div>
    </section>
    </div>
    @section('js')
<script>
$(document).ready(function() {
    $('#id_dosencari, #semester').on('change', function() {
        var dosenId = $('#id_dosencari').find(':selected').data('id');
        var semester = $('#semester').val();
        var mahasiswaId = $('#id_mahasiswa').val();
        if (dosenId && semester && mahasiswaId) {
            $.ajax({
                url: '{{ route("get-perkuliahan") }}',
                type: 'GET',
                data: {
                    dosen_id: dosenId,
                    semester: semester,
                    id_mahasiswa: mahasiswaId
                },
                success: function(data) {
                    var options = '<option value="">Pilih Mata Kuliah - Semester</option>';
                    $.each(data, function(index, value) {
                        options += '<option value="' + value.perkuliahan_id + '">' + value.matakuliah_kode + ' - ' + value.matakuliah_nama + ' - SMT ' + value.smt + '</option>';
                    });
                    $('#perkuliahan_id').html(options);
                }
            });
        } else {
            $('#perkuliahan_id').html('<option value="">Pilih Mata Kuliah - Semester</option>');
        }
    });
});
</script>
@stop
@endsection
