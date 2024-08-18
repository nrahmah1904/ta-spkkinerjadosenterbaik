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
        <div class="card card-info">
            <div class="card-header">
                Print Hasil Nilai
            </div>
            <div class="card-body">
                <form class="form-inline" action="{{url('nilai-print')}}" method="get" target="_blank">

                    <div class="form-group">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select class="form-control " name="tahun_ajaran_id" id="tahun_ajaran_id" required>
                            @foreach($tahunAjarans as $tahunAjaran)
                                <option value="{{ $tahunAjaran->id }}" {{ $tahunAjaranAktif && $tahunAjaranAktif->id == $tahunAjaran->id ? 'selected' : '' }}>{{ $tahunAjaran->tahun_ajaran }} {{ $tahunAjaran->ganjil_genap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Print</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection