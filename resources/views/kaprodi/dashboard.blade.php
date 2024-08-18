<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard Kaprodi</title>
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
        height: 60vh;
        max-height: 600px;
        margin: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .left-column img {
        width: 100%;
        max-width: 300px;
    }

    .btn-primary {
        background: #aaa;
        border: none;
    }

    .btn-primary:hover {
        background: #888;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row align-items-center w-100">
            <div class="col-md-6 text-center left-column">
                <img src="{{ asset('/template/frontend/images/logo.png') }}" alt="Logo">
            </div>
            <div class="col-md-6 text-center right-column">
                <h5 class="mb-3"><b>Penilaian Kinerja Dosen</b></h5>
                <h6 class="mb-2">REKOMENDASI DOSEN TERBAIK PROGRAM STUDI INFORMATIKA</h6>
                <h6 class="mb-2">UNIVERSITAS MUHAMMADIYAH BANJARMASIN</h6>
                <a href="{{ route('dosen-terbaik') }}" class="btn btn-primary mt-4">Lihat Rekomendasi</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>