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
                <h6 class="m-0 font-weight-bold text-primary">Data Perkuliahan</h6>
                <div class="mb-4"></div>
                <a href="{{ route('perkuliahan.create') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Tambah</span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Dosen</th>
                                <th>NIDN</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perkuliahans as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->matkul->kode }}</td>
                                <td>{{ $item->matkul->nama }}</td>
                                <td>{{ $item->matkul->sks }}</td>
                                <td>{{ $item->matkul->smt }}</td>
                                <td>{{ $item->dosen->nama }}</td>
                                <td>{{ $item->kelas }}</td>
                                <td>
                                    <a href="{{ route('perkuliahan.edit', $item->id) }}"
                                        class="btn btn-primary btn-circle btn-sm" class="btn btn-primary btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('perkuliahan.destroy', $item->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
<!-- End of Topbar -->
@endsection