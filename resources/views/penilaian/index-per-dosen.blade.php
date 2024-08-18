@extends('master')
@section('content')
<div class="content-wrapper mb-4 pb-4">
    <section class="content-header">
    </section>
    <section class="content mb-4 pb-4">
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
                <h6 class="m-0 font-weight-bold text-primary">Data Pemberian Nilai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach ($dosenPerkuliahan as $nidn => $perkuliahanGroup)
                            @php
                            $dosen = $perkuliahanGroup->first()->dosen;
                            @endphp
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $dosen->nidn }}</td>
                                <td>{{ $dosen->nama }}</td>
                                <td>
                                    <a href="{{ route('penilaian.indexadmin', ['dosen_nidn' => $dosen->nidn]) }}"
                                        class="btn btn-info btn-sm">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form action="{{ route('periode-penilaian-selesai') }}" method="post" id="periode-penilaian-form"
            class="float-right mt-2 mb-4" style="display: {{ $tahunAjaranAktif ? 'inline-block' : 'none' }}">
            @csrf
            <button type="button" class="btn btn-success" onclick="confirmSelesai()">Periode Penilaian Selesai</button>
        </form>
    </section>
</div>
@endsection
@section('js')
<script>
function confirmSelesai() {
    if (confirm('Apakah Anda yakin ingin mengakhiri periode penilaian?')) {
        document.getElementById('periode-penilaian-form').submit();
    }
}
</script>
@stop