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

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Tahun Ajaran</h6>
                <div class="mb-4"></div>
                <a href="{{ route('tahunajaran.create') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Tambah</span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>Status Aktif</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tahunAjarans as $e => $item)
                            <tr>
                                <td>{{ $e + 1 }}</td>
                                <td>{{ $item->tahun_ajaran }} {{ $item->ganjil_genap }}</td>
                                <td>
                                    @if ($item->is_active == 'Aktif')
                                    <span class="btn btn-primary btn-sm">Aktif</span>
                                    @elseif ($item->is_active == 'Terlaksana')
                                    <span class="btn btn-info btn-sm">Terlaksana</span>
                                    @else
                                    <span class="btn btn-danger btn-sm">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->is_active != 'Terlaksana')
                                    <a href="{{ route('tahunajaran.edit', $item->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('tahunajaran.destroy', $item->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                    @else
                                    <a href="{{ route('penilaian.tahunajaran', $item->id) }}"
                                        class="btn btn-info btn-sm">Lihat Hasil Pemberian Nilai</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection