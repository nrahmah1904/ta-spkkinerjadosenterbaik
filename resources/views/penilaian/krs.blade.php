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
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian</h6>
                    <div class="mb-4"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <p>Anda berada di semester {{ $semester }}.</p>
                        @if (!empty($perkuliahans))
                            <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>Mata Kuliah</th>
                                        <th>Semester</th>
                                        <th>Penilaian PBM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perkuliahans as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->dosen->nidn }}</td>
                                            <td>{{ $item->dosen->nama }}</td>
                                            <td>{{ $item->matkul->nama }}</td>
                                            <td>{{ $item->matkul->smt }}</td>
                                            <td>
                                                @if ($item->nilai->isNotEmpty())
                                                    <button class="btn btn-success btn-sm" disabled>Sudah Dinilai</button>
                                                @else
                                                    <a href="{{ route('penilaian.beri-nilai', $item->id) }}" class="btn btn-dark btn-sm">Beri Nilai</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Belum ada perkuliahan untuk semester ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
