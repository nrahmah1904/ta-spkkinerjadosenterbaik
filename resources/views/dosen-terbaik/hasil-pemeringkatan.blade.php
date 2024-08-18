<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hasil Pemeringkatan</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Hasil Pemeringkatan</h3>
            @if($allValidated)
            <a href="{{ route('laporan-cetak') }}" class="btn btn-secondary">Laporan Cetak</a>
            @endif
        </div>
        <table class="table table-bordered" id="rankingTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($ranking as $rank)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $rank->nidn }}</td>
                    <td>{{ $rank->nama_dosen }}</td>
                    <td>{{ $rank->kode }}</td>
                    <td>{{ $rank->nama_matakuliah }}</td>
                    <td>{{ number_format($rank->rank, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-end mt-3">
            <form action="{{ route('validasi-rank') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Validasi Semua</button>
            </form>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#rankingTable').DataTable();
    });
    </script>
</body>

</html>