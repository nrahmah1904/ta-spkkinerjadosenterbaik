@extends('master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
            </div>
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
                    <h6 class="m-0 font-weight-bold text-primary">Beri Penilaian - {{ $perkuliahan->matkul->nama }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="source" value="{{ request()->routeIs('penilaian.krs') ? 'krs' : 'semester' }}">
 
                        <input type="hidden" name="id" value="{{ $perkuliahan->id }}">
                        <input type="hidden" name="nim" value="{{ auth()->user()->mahasiswa->nim }}">
                        <input type="hidden" name="id_dosencari" value="{{ $perkuliahan->dosen->nidn }}">
                        <input type="hidden" name="perkuliahan_id" value="{{ $perkuliahan->id }}">
                        <input type="hidden" name="semester" value="{{ $perkuliahan->matkul->smt }}">
                        <input type="hidden" name="tahun_ajaran" value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}">

                        {{-- <div class="form-group">
                            <label for="tahunAjaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahunAjaran" value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}" readonly>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" id="nidn" value="{{ $perkuliahan->dosen->nidn }}" readonly>
                        </div> --}}
                        <div class="form-group">
                            <label for="smt">Semester</label>
                            <input type="text" class="form-control" id="smt" value="{{ $perkuliahan->matkul->smt }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dosen">Dosen</label>
                            <input type="text" class="form-control" id="dosen" value="{{ $perkuliahan->dosen->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="matkul">Mata Kuliah</label>
                            <input type="text" class="form-control" id="matkul" value="{{ $perkuliahan->matkul->nama }}" readonly>
                        </div>
                       

                        <div class="form-group">
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
                                            <input type="hidden" name="id_kriteria[]" value="{{ $s->id }}">
                                            <td>{{ $e + 1 }}</td>
                                            <td>{{ $s->kriteria }}</td>
                                            <td>
                                                <input id="jawaban{{ $e }}" type="radio" name="jawaban[{{ $e }}]" value="1" required>
                                            </td>
                                            <td>
                                                <input id="jawaban{{ $e }}" type="radio" name="jawaban[{{ $e }}]" value="2" required>
                                            </td>
                                            <td>
                                                <input id="jawaban{{ $e }}" type="radio" name="jawaban[{{ $e }}]" value="3" required>
                                            </td>
                                            <td>
                                                <input id="jawaban{{ $e }}" type="radio" name="jawaban[{{ $e }}]" value="4" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
