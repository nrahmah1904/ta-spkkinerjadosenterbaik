@extends('master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (auth()->user()->level == 'Admin' || auth()->user()->level == 'Upm')
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah Data Mahasiswa
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $mahasiswaCount ?? 'Data tidak tersedia' }} Orang
                                    </div>
                                    <br>
                                    @if (auth()->user()->level == 'Admin')
                                    <a href="{{ url('/mahasiswa') }}" class="small-box-footer"
                                        style="font-size: 12px">Lihat Selanjutnya <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Data
                                        Dosen</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h8 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ $dosenCount ?? 'Data tidak tersedia' }} Orang
                                            </div>
                                            <br>
                                            <a href="{{ url('/dosen') }}" class="small-box-footer"
                                                style="font-size: 12px">Lihat Selanjutnya <i
                                                    class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Data Kriteria
                                    </div>
                                    <div class="h8 mb-0 font-weight-bold text-gray-800">
                                        {{ $kriteriaCount ?? 'Data tidak tersedia' }} kriteria
                                    </div>
                                    <br>
                                    <a href="{{ url('/kriteria') }}" class="small-box-footer"
                                        style="font-size: 12px">Lihat Selanjutnya <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Data Matakuliah
                                        {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran .' '. $tahunAjaranAktif->ganjil_genap : 'Tidak Ada' }}
                                    </div>
                                    <div class="h8 mb-0 font-weight-bold text-gray-800">
                                        61 Matakuliah
                                    </div>
                                    <br>
                                    <a href="{{ url('/matakuliah') }}" class="small-box-footer"
                                        style="font-size: 12px">Lihat Selanjutnya <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Data Perkuliahan
                                        {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran .' '. $tahunAjaranAktif->ganjil_genap : 'Tidak Ada' }}
                                    </div>
                                    <a href="{{ url('/perkuliahan') }}" class="small-box-footer"
                                        style="font-size: 12px">Lihat Selanjutnya <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-7 mb-4">
                    <div class="card border-left-success shadow h-100 ">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Hasil Penilaian
                                    </div>
                                    <div class="h8 mb-0 font-weight-bold text-gray-800">
                                        <a href="{{ url('/penilaian/admin') }}" class="small-box-footer"
                                            style="font-size: 12px">Lihat Selanjutnya <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-edit fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                @if ($krsCount == 0)
                <div class="alert alert-warning">
                    Anda belum mengisi KRS untuk semester ini. <a href="{{ url('/krs/create') }}">Silakan
                        mengisi
                        KRS</a> agar dapat melanjutkan perkuliahan.
                </div>
                @elseif (!$krsValidated)
                <div class="alert alert-warning">
                    KRS Anda belum divalidasi oleh admin.
                </div>
                @else
                <div class="alert alert-info">
                    Silahkan beri Penilaian
                </div>
                @endif

                <section class="content">
                    <div class="content">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5></h5>
                            </div>

                            <div class="card-body">
                                <h2>Penilaian Kinerja Dosen</h2>
                                <p align="justify">
                                    Penilaian kinerja dosen merupakan suatu proses dimana lembaga melakukan
                                    evaluasi
                                    atau menilai kinerja dosen atau mengevaluasi hasil pekerjaan dosen.
                                </p>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </section>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection