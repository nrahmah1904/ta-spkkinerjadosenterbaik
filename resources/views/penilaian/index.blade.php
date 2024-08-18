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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#semesterModal">
                        Pilih Semester
                    </button>
                    <br><br>
                    @if (isset($semester))
                    <p>Anda memilih semester {{ $semester }}.</p>
                    @endif
                    @if ($perkuliahans->isNotEmpty())
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
                                    <a href="{{ route('penilaian.beri-nilai', $item->id) }}"
                                        class="btn btn-dark btn-sm">Beri Nilai</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Pilih semester terlebih dahulu untuk menampilkan perkuliahan.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Semester Modal -->
    <div class="modal fade" id="semesterModal" tabindex="-1" role="dialog" aria-labelledby="semesterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="semesterModalLabel">Pilih Semester</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="semesterForm" method="GET">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Pilih</option>
                                @if ($tahunAjaranAktif->ganjil_genap == 'Ganjil')
                                <option value="1">1</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                @else
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                                @endif
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitSemesterForm()">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitSemesterForm() {
    const semester = document.getElementById('semester').value;
    const form = document.getElementById('semesterForm');
    const action = '{{ route('
    penilaian.index ', ['
    semester ' => ': semester ']) }}';
    form.action = action.replace(':semester', semester);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    @if(!isset($semester))
    $('#semesterModal').modal('show');
    @endif
});
</script>
@endsection