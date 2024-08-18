@extends('master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
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
                <h6 class="m-0 font-weight-bold text-primary">Detail Penilaian - {{ $perkuliahan->matkul->nama }}</h6>
                <a href="{{ route('penilaian.index-per-dosen') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    <input type="hidden" name="id_dosencari" value="{{ $perkuliahan->dosen->nidn }}">
                    <input type="hidden" name="perkuliahan_id" value="{{ $perkuliahan->id }}">
                    <input type="hidden" name="semester" value="{{ $perkuliahan->matkul->smt }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}">
                    <div class="form-group">
                        <label for="tahunAjaran">Tahun Ajaran</label>
                        <input type="text" class="form-control" id="tahunAjaran"
                            value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" id="nidn" value="{{ $perkuliahan->dosen->nidn }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="dosen">Dosen</label>
                        <input type="text" class="form-control" id="dosen" value="{{ $perkuliahan->dosen->nama }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Pilih Pertemuan</label>
                        <select class="form-control" id="kategori" name="kategori" onchange="showCriteria()">
                            <option value="">Pilih Pertemuan</option>
                            @foreach ($criteriaGroups as $key => $criteria)
                            <option value="{{ $key }}">{{ 'Pertemuan ' . str_replace('_', '-', $key) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="criteriaContainer"></div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
const criteriaGroups = @json($criteriaGroups);

function showCriteria() {
    const selectedCategory = document.getElementById('kategori').value;
    const criteriaContainer = document.getElementById('criteriaContainer');
    criteriaContainer.innerHTML = '';

    if (!selectedCategory) return;

    const criteria = criteriaGroups[selectedCategory] || [];
    if (criteria.length === 0) {
        return;
    }

    let tableHtml = `<h5>Pertemuan ${selectedCategory.replace('_', '-')}</h5>`;
    tableHtml += `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>0</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                    </tr>
                </thead>
                <tbody>
        `;
    criteria.forEach((criterion, index) => {
        const selectedValue = criterion.jawaban;

        if (selectedValue !== null) {
            tableHtml += `
                    <tr>
                        <input type="hidden" name="id_kriteria[]" value="${criterion.id}">
                        <td>${index + 1}</td>
                        <td>${criterion.kriteria}</td>
                        ${[...Array(7).keys()].map(i => `
                            <td>
                                <input type="radio" name="jawaban[${index}]" value="${i}" ${selectedValue == i ? 'checked' : ''} disabled>
                            </td>
                        `).join('')}
                    </tr>
                `;
        }
    });
    tableHtml += '</tbody></table>';
    criteriaContainer.innerHTML = tableHtml;
}

document.addEventListener('DOMContentLoaded', () => {
    showCriteria();
});
</script>
@endsection