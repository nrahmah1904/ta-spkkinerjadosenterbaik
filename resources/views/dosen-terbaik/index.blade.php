<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dosen Terbaik</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        background-color: #0066cc;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        border-radius: 10px;
        background: white;
        padding: 20px;
        width: 80vw;
        max-width: 1200px;
        margin: 20px;
    }

    table {
        width: 100%;
        font-size: 0.9rem;
    }

    .btn-primary,
    .btn-secondary {
        border: none;
    }

    .btn-primary:hover,
    .btn-secondary:hover {
        background: #888;
    }
    </style>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="container">
        <h3 class="mb-4">Rekomendasi Dosen Terbaik</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($dosenTerbaik as $dosen)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $dosen->nidn }}</td>
                    <td>{{ $dosen->nama_dosen }}</td>
                    <td>{{ $dosen->kode }}</td>
                    <td>{{ $dosen->nama_matakuliah }}</td>
                    <td>{{ number_format($dosen->rank, 2) }}</td>
                    <td>Dosen Terbaik {{ $tahunAjaranAktif->tahun_ajaran }} {{ $tahunAjaranAktif->ganjil_genap }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-end">
            <a href="{{ route('hasil-pemeringkatan') }}" class="btn btn-primary">Hasil Pemeringkatan</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>