@extends('master')
@section('content')
    <!-- End of Topbar -->
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
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Perkuliahan</h6>
                    <div class="mb-4"></div>
                    <a href="{{ route('perkuliahan.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="text">Kembali</span>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('perkuliahan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ $tahunAjaranAktif->tahun_ajaran }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ganjil_genap">Semester</label>
                            <input type="text" class="form-control" id="ganjil_genap" name="ganjil_genap" value="{{ $tahunAjaranAktif->ganjil_genap }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas">
                        </div>
                        <div class="form-group">
                            <label for="nidn">Dosen</label>
                            <select class="form-control" id="nidn" name="nidn">
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->nidn }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Mata Kuliah</label>
                            <select class="form-control" id="kode" name="kode">
                                @foreach($matkuls as $matkul)
                                    <option value="{{ $matkul->kode }}">{{ $matkul->nama }} / Smt : {{ $matkul->smt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- End of Topbar -->
@endsection
