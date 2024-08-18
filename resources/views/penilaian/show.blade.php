@extends('master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penilaian - {{ $perkuliahan->matkul->nama }}</h6>
                <a href="{{ route('penilaian.index-per-dosen') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>NIDN</label>
                    <input type="text" class="form-control" value="{{ $perkuliahan->dosen->nidn }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Dosen</label>
                    <input type="text" class="form-control" value="{{ $perkuliahan->dosen->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label>Kode Mata Kuliah</label>
                    <input type="text" class="form-control" value="{{ $perkuliahan->matkul->kode }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Mata Kuliah</label>
                    <input type="text" class="form-control" value="{{ $perkuliahan->matkul->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah Mahasiswa</label>
                    <input type="text" class="form-control" value="{{ $jumlahMahasiswa }}" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah Mahasiswa yang Menilai</label>
                    <input type="text" class="form-control" value="{{ $jumlahMahasiswaMemilih }}" readonly>
                </div>

                <hr>

                <div class="form-group">
                    <label for="mahasiswaSelect">Pilih Mahasiswa</label>
                    <select class="form-control" id="mahasiswaSelect" onchange="showPenilaianDetails(this.value)">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($perkuliahan->nilai as $index => $pen)
                        <option value="{{ $index }}">{{ $pen->mahasiswa->nama }}</option>
                        @endforeach
                    </select>
                </div>

                @foreach($perkuliahan->nilai as $index => $pen)
                <div id="penilaian-details-{{ $index }}" style="display: none;">
                    <div class="form-group">
                        <label>Tanggal Penilaian</label>
                        <input type="text" class="form-control" value="{{ $pen->tanggal_penilaian }}" readonly>
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
                            @php
                            $tot_jawaban = 0;
                            $no = 1;
                            @endphp
                            @foreach($pen->evaluasimhs as $e => $eval)
                            @php
                            $jawaban = $eval->jawaban;
                            $tot_jawaban += $jawaban;
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ optional($eval->kriteria)->kriteria }}</td>
                                <td>
                                    <input type="radio" class="form-control" name="jawaban[{{ $index }}][{{ $e }}]"
                                        value="1" style="width: 20px;" {{ $jawaban == 1 ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="radio" class="form-control" name="jawaban[{{ $index }}][{{ $e }}]"
                                        value="2" style="width: 20px;" {{ $jawaban == 2 ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="radio" class="form-control" name="jawaban[{{ $index }}][{{ $e }}]"
                                        value="3" style="width: 20px;" {{ $jawaban == 3 ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="radio" class="form-control" name="jawaban[{{ $index }}][{{ $e }}]"
                                        value="4" style="width: 20px;" {{ $jawaban == 4 ? 'checked' : '' }} disabled>
                                </td>
                            </tr>
                            @endforeach
                            <tr align="center">
                                <th colspan="2">Total Nilai</th>
                                <th colspan="4">{{ $tot_jawaban }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
                <div class="card-footer" style="background-color: white;"><br>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection