<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LAPORAN</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Untuk load bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
    @page {
        size: A4;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: auto;
    }

    h1,
    h2 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    th {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .sub-table th,
    .sub-table td {
        border: 1px solid #bbb;
        padding: 6px;
    }

    .sub-table {
        width: 100%;
        margin-top: 10px;
    }
    </style>
</head>

<body class="A4">
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <img src="{{ asset('/template/frontend/images/logo.png') }}"
            style="width: 50px;float: left;margin-right: 10px;">
        <b>
            <p class="text-center" style="margin-bottom: 0px;">LAPORAN REKOMENDASI EVALUASI KINERJA DOSEN</p>
            <p class="text-center" style="margin-bottom: 0px;">BERDASARKAN EDOM DAN KEHADIRAN DOSEN PROGRAM STUDI
                INFORMATIKA</p>
            <p class="text-center" style="margin-bottom: 0px;">UNIVERSITAS MUHAMMADIYAH BANJARMASIN</p>
        </b>
        <hr>

        <br><b>
            <p style="text-align:justify;">Tahun Ajaran : {{ $detailtahun->tahun_ajaran }}
                {{ $detailtahun->ganjil_genap }}
            </p>
        </b>

        <table class="sub-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Nilai</th>
                    <th>Status Dosen</th>
                </tr>
            </thead>
            <tbody style="font-size: 13px">
                @if($penilaian->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Data Pada Periode ini tidak ada</td>
                </tr>
                @else
                @foreach ($penilaian as $e => $s)
                <tr>
                    <td>{{ $e + 1 }}</td>
                    <td>{{ $s->nidn }}</td>
                    <td>{{ $s->nama_dosen }}</td>
                    <td>{{ $s->nama_matkul }}</td>
                    <td>{{ number_format((float) $s->total_rank, 2, '.', '') }}</td>
                    <td style="text-align: center;">{{ $s->total_rank > 62.5 ? 'Aman' : 'Diberikan Teguran' }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </section>
</body>

</html>