@extends('master')
@section('content')
<div class="content-wrapper mb-4 pb-4">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Monitoring Kehadiran Dosen</h1>
        </div>
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
        <a href="{{ route('monitoring_kehadiran.rekapitulasi', ['kategori' => $kategori]) }}" class="btn btn-primary ml-2 mb-2 float-right" target="_blank">Hasil Rekapitulasi</a>

        <div class="clearfix"></div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Monitoring Kehadiran Dosen</h6>
                <div>
                    <form action="{{ route('monitoring_kehadiran.index') }}" method="GET" class="form-inline">
                        <label for="kategori" class="mr-2">Filter Kategori:</label>
                        <select name="kategori" id="kategori" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="1_3" {{ $kategori == '1_3' ? 'selected' : '' }}>1-3</option>
                            <option value="4_6" {{ $kategori == '4_6' ? 'selected' : '' }}>4-6</option>
                            <option value="7_9" {{ $kategori == '7_9' ? 'selected' : '' }}>7-9</option>
                            <option value="10_12" {{ $kategori == '10_12' ? 'selected' : '' }}>10-12</option>
                            <option value="13_15" {{ $kategori == '13_15' ? 'selected' : '' }}>13-15</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Jumlah Pertemuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach ($perkuliahanGroupedByDosen as $dosenNidn => $perkuliahanGroup)
                            @php
                            $dosen = $perkuliahanGroup->first()->dosen;
                            @endphp
                            <tr>
                                <td rowspan="{{ $perkuliahanGroup->count() }}" class="align-middle">{{ $index++ }}</td>
                                <td rowspan="{{ $perkuliahanGroup->count() }}" class="align-middle">{{ $dosen->nidn }}</td>
                                <td rowspan="{{ $perkuliahanGroup->count() }}" class="align-middle">{{ $dosen->nama }}</td>
                                @foreach ($perkuliahanGroup as $perkuliahan)
                                @if (!$loop->first)
                                <tr>
                                    @endif
                                    <td>{{ $perkuliahan->matkul->kode }}</td>
                                    <td>{{ $perkuliahan->matkul->nama }}</td>
                                    <td>{{ $perkuliahan->monitoringKehadiran->jumlah_pertemuan ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="openModal('{{ $perkuliahan->id }}', '{{ $kategori }}', '{{ $perkuliahan->monitoringKehadiran->jumlah_pertemuan ?? '' }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('monitoring_kehadiran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perkuliahan_id" id="perkuliahan_id">
                    <input type="hidden" name="kategori" id="kategori_modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Jumlah Pertemuan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="jumlah_pertemuan">Jumlah Pertemuan</label>
                                <input type="number" class="form-control" name="jumlah_pertemuan" id="jumlah_pertemuan" min="1" max="3" required>
                                <small id="maxInfo" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@section('js')
<script>
    function openModal(perkuliahanId, kategori, jumlahPertemuan) {
        const [minPertemuan, maxPertemuan] = kategori.split('_');
        document.getElementById('perkuliahan_id').value = perkuliahanId;
        document.getElementById('kategori_modal').value = kategori;
        const jumlahPertemuanInput = document.getElementById('jumlah_pertemuan');
        jumlahPertemuanInput.value = jumlahPertemuan;
        jumlahPertemuanInput.max = maxPertemuan;

        const maxInfo = document.getElementById('maxInfo');
        maxInfo.textContent = `Maksimal jumlah pertemuan untuk kategori ini adalah ${maxPertemuan}.`;

        $('#editModal').modal('show');
    }
</script>
@stop
@endsection
