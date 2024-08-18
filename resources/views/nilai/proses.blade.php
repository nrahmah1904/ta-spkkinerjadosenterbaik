@extends('master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Data Proses Penilaian Dosen Selanjutnya</h5>
            </div>
            <div class="card-body">
                @if($evaluasiUpm->isEmpty())
                <form action="/nilai/store2" method="post">
                    @csrf
                    <input type="hidden" name="tanggal_penilaian" value="{{ now()->toDateString() }}">
                    <input type="hidden" name="id"
                        value="{{ str_pad($evaluasiUpm->count() + 1, 4, '0', STR_PAD_LEFT) }}">

                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" class="form-control" name="semester" value="{{ $perkuliahan->smt }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>NIDN</label>
                        <input type="text" class="form-control" name="nidn" value="{{ $perkuliahan->nidn }}" readonly>
                        <input type="hidden" class="form-control" name="perkuliahan_id" value="{{ $perkuliahan->id }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Dosen</label>
                        <input type="text" class="form-control" name="nama_dosen" value="{{ $perkuliahan->nama_dosen }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Matakuliah</label>
                        <input type="text" class="form-control" value="{{ $perkuliahan->nama_matkul }}" readonly>
                        <input type="hidden" class="form-control" name="kode" value="{{ $perkuliahan->kode }}" readonly>
                    </div>
                    <hr>
                    <table class="table table-bordered">
                        <h5>Pertemuan 1 - 3</h5>
                        <thead>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th>Pertanyaan</th>
                                <th style="width: 5%;">1</th>
                                <th style="width: 5%;">2</th>
                                <th style="width: 5%;">3</th>
                                <th style="width: 5%;">4</th>
                                <th style="width: 5%;">5</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px">
                            @foreach($kriteria as $e => $s)
                            <tr>
                                <input type="hidden" name="id_kriteria[]" value="{{ $s->id }}">
                                <td>{{ $e + 1 }}</td>
                                <td>{{ $s->kriteria }}</td>
                                <td><input type="radio" name="jawaban[{{ $e }}]" value="1" style="width: 20px;"></td>
                                <td><input type="radio" name="jawaban[{{ $e }}]" value="2" style="width: 20px;"></td>
                                <td><input type="radio" name="jawaban[{{ $e }}]" value="3" style="width: 20px;"></td>
                                <td><input type="radio" name="jawaban[{{ $e }}]" value="4" style="width: 20px;"></td>
                                <td><input type="radio" name="jawaban[{{ $e }}]" value="5" style="width: 20px;"></td>
                            </tr>
                            <input type="hidden" name="pengguna[]" value="{{ $s->pengguna }}">
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-footer" style="background-color: white;">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
                @else
                <div class="form-group">
                    <label>Semester</label>
                    <input type="text" class="form-control" name="semester" value="{{ $perkuliahan->smt }}" readonly>
                </div>
                <div class="form-group">
                    <label>NIDN</label>
                    <input type="text" class="form-control" name="nidn" value="{{ $perkuliahan->nidn }}" readonly>
                </div>
                <div class="form-group">
                    <label>Dosen</label>
                    <input type="text" class="form-control" name="nama_dosen" value="{{ $perkuliahan->nama_dosen }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label>Matakuliah</label>
                    <input type="text" class="form-control" value="{{ $perkuliahan->nama_matkul }}" readonly>
                    <input type="hidden" class="form-control" name="kode" value="{{ $perkuliahan->kode }}" readonly>
                </div>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No</th>
                            <th>Pertanyaan</th>
                            <th style="width: 5%;">1</th>
                            <th style="width: 5%;">2</th>
                            <th style="width: 5%;">3</th>
                            <th style="width: 5%;">4</th>
                            <th style="width: 5%;">5</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        @foreach($evaluasiUpm as $e => $s)
                        <tr>
                            <td>{{ $e + 1 }}</td>
                            <td>{{ $s->kriteria }}</td>
                            <td>
                                <input type="radio" class="form-control" name="jawaban[{{ $e }}]" value="1"
                                    style="width: 20px;" disabled @if($s->jawaban == '1') checked @endif>
                            </td>
                            <td>
                                <input type="radio" class="form-control" name="jawaban[{{ $e }}]" value="2"
                                    style="width: 20px;" disabled @if($s->jawaban == '2') checked @endif>
                            </td>
                            <td>
                                <input type="radio" class="form-control" name="jawaban[{{ $e }}]" value="3"
                                    style="width: 20px;" disabled @if($s->jawaban == '3') checked @endif>
                            </td>
                            <td>
                                <input type="radio" class="form-control" name="jawaban[{{ $e }}]" value="4"
                                    style="width: 20px;" disabled @if($s->jawaban == '4') checked @endif>
                            </td>
                            <td>
                                <input type="radio" class="form-control" name="jawaban[{{ $e }}]" value="5"
                                    style="width: 20px;" disabled @if($s->jawaban == '5') checked @endif>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection