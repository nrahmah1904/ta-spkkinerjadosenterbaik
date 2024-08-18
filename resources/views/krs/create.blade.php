@extends('master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Buat KRS Baru</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ url('/krs/store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="semester">Semester: {{ $semester }}</label>
                            <input type="hidden" name="semester" value="{{ $semester }}">
                        </div>
                        <div class="form-group">
                            <label>Pilih Perkuliahan</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Mata Kuliah</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Semester</th>
                                        <th>Nama Dosen</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($perkuliahanEntries as $perkuliahan)
                                    <tr>
                                        <td>{{ $perkuliahan->matkul->kode }}</td>
                                        <td>{{ $perkuliahan->matkul->nama }}</td>
                                        <td>{{ $perkuliahan->matkul->sks }}</td>
                                        <td>{{ $perkuliahan->matkul->smt }}</td>
                                        <td>{{ $perkuliahan->dosen->nidn }} - {{ $perkuliahan->dosen->nama }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="perkuliahan_id[]"
                                                       id="perkuliahan_{{ $perkuliahan->id }}" value="{{ $perkuliahan->id }}">
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
