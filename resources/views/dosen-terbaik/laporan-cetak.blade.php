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
        background-color: #999;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    * {
        font-family: "Arial";
    }

    .text-center {
        text-align: center;
    }

    h1 {
        font-size: 20px;
    }

    h3 {
        font-size: 14px;
        font-weight: normal;
        margin-top: -8px;
    }

    h4 {
        margin-top: 20px;
        text-transform: uppercase;
        margin-bottom: -10px;
    }

    td {
        padding: 5px !important;
        vertical-align: middle !important;
    }

    table {
        font-size: 12px;
    }
    </style>
</head>

<body class="A4">
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <img src="https://umbjm.ac.id/wp-content/uploads/2016/05/logo-19-12-tanpa-bayang-1.png"
            style="width: 50px;float: left;margin-right: 10px;" class="text-center">
        <h1 class="text-center" style="margin-bottom: 0px;">Universitas Muhammadiyah Banjarmasin</h1>
        <p class="text-center" style="margin-bottom: 0px;">Jl. S. Parman Kompleks RS Islam, Ps. Lama, Kec. Banjarmasin
            Tengah, Kota Banjarmasin, Kalimantan Selatan 70114</p>
        <hr>

        <h5 class="text-center text-uppercase text-decoration-underline mt-4">LAPORAN HASIL PEMERINGKATAN DOSEN</h5>
        <br>
        <p style="text-align:justify;">TAHUN AJARAN : {{ $tahunAjaranAktif->tahun_ajaran }}
            {{ $tahunAjaranAktif->ganjil_genap }}</p>

        <table class="table table-bordered" width="100%" cellspacing="0">
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
                @php $index = 1; @endphp
                @foreach ($ranking as $rank)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $rank->nidn }}</td>
                    <td>{{ $rank->nama_dosen }}</td>
                    <td>{{ $rank->kode }}</td>
                    <td>{{ $rank->nama_matakuliah }}</td>
                    <td>{{ number_format($rank->rank, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>

</html>