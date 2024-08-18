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
                    <h6 class="m-0 font-weight-bold text-primary">Beri Penilaian - {{ $perkuliahan->matkul->nama }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('evaluasi.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="id_dosencari" value="{{ $perkuliahan->dosen->nidn }}">
                        <input type="hidden" name="perkuliahan_id" value="{{ $perkuliahan->id }}">
                        <input type="hidden" name="semester" value="{{ $perkuliahan->matkul->smt }}">
                        <input type="hidden" name="tahun_ajaran" value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}">
                        <div class="form-group">
                            <label for="tahunAjaran">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahunAjaran" value="{{ $perkuliahan->tahunAjaran->tahun_ajaran }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nidn">NIDN</label>
                            <input type="text" class="form-control" id="nidn" value="{{ $perkuliahan->dosen->nidn }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dosen">Dosen</label>
                            <input type="text" class="form-control" id="dosen" value="{{ $perkuliahan->dosen->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Pilih Pertemuan</label>
                            <select class="form-control" id="kategori" name="kategori" onchange="showCriteria()">
                                <option value="1_3">Pertemuan 1-3</option>
                                <option value="4_6">Pertemuan 4-6</option>
                                <option value="7_9">Pertemuan 7-9</option>
                                <option value="10_12">Pertemuan 10-12</option>
                                <option value="13_15">Pertemuan 13-15</option>
                            </select>
                        </div>

                        <div id="criteriaContainer"></div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
<script>
    const criteriaGroups = {
        '1_3': @json($criteria1_3),
        '4_6': @json($criteria4_6),
        '7_9': @json($criteria7_9),
        '10_12': @json($criteria10_12),
        '13_15': @json($criteria13_15),
    };

    const existingEvaluations = @json($existingEvaluations);

    function showCriteria() {
        const selectedCategory = document.getElementById('kategori').value;
        const criteriaContainer = document.getElementById('criteriaContainer');
        criteriaContainer.innerHTML = '';

        const criteria = criteriaGroups[selectedCategory];
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
            const existingEvaluation = existingEvaluations[selectedCategory] ? existingEvaluations[selectedCategory][criterion.id] : null;
            const selectedValue = existingEvaluation ? existingEvaluation.jawaban : null;

            tableHtml += `
                <tr>
                    <input type="hidden" name="id_kriteria[]" value="${criterion.id}">
                    <td>${index + 1}</td>
                    <td>${criterion.kriteria}</td>
                    ${[...Array(7).keys()].map(i => `
                        <td>
                            <input type="radio" name="jawaban[${index}]" value="${i}" ${selectedValue == i ? 'checked' : ''} required>
                        </td>
                    `).join('')}
                </tr>
            `;
        });
        tableHtml += '</tbody></table>';
        criteriaContainer.innerHTML = tableHtml;
    }

    document.addEventListener('DOMContentLoaded', showCriteria);
</script>
@endsection