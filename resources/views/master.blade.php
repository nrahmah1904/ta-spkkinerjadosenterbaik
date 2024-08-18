<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPK KINERJA DOSEN</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('SB2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('SB2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @section('css')
    @show
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div>
                    <img src="{{ asset('/template/frontend/images/logo.png') }}" alt="image" height="42" width="42"></i>
                </div>
                <div class=" sidebar-brand-text mx-3" style="font-size: large;">S1 INFORMATIKA
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/beranda">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @if (auth()->user()->level == 'Admin')
            <li class="nav-item ">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-chart-pie"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">DATA:</h6>
                        <a class="collapse-item collapse-item active" href="/dosen">Dosen</a>
                        <a class="collapse-item collapse-item active" href="/matakuliah">Mata Kuliah</a>
                        <a class="collapse-item collapse-item active" href="/mahasiswa">Mahasiswa</a>
                        <a class="collapse-item collapse-item active" href="/kriteria">Kriteria</a>
                        <a class="collapse-item collapse-item active" href="/skalanilai">Skala Nilai</a>
                        <a class="collapse-item collapse-item active" href="{{ route('tahunajaran.index') }}">Tahun
                            Ajaran</a>
                        <a class="collapse-item collapse-item active"
                            href="{{ route('perkuliahan.index') }}">Perkuliahan</a>
                        <!-- <a class="collapse-item active" href="/">Tahun ajaran</a> -->
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-edit"></i>
                    <span>Penilaian</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">MENU :</h6>
                        <a class="collapse-item active" href="{{ route('penilaian.index-per-dosen') }}">Hasil Pemberian
                            Nilai</a> <a class="collapse-item active"
                            href="{{ route('penilaian.indexadmin.semester') }}">Hasil Persemester</a>

                        <a class="collapse-item active" href="/saw">Hasil Pemeringkatan</a>
                    </div>
                </div>
            </li>
            @endif
            @if (auth()->user()->level == 'Mahasiswa')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-edit"></i>
                    <span>Penilaian PBM Dosen</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h3 class="collapse-header">Menu</h3>
                        <a class="collapse-item active" href="{{ route('penilaian.krs') }}">Beri Penilaian PBM
                            Dosen</a>
                        {{-- <a class="collapse-item active" href="{{ route('penilaian.krs') }}">Penilaian Per
                        Semester</a> --}}
                    </div>
                </div>
            </li>
            @endif
            @if (auth()->user()->level == 'Upm')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span style="font-size: 12px !important;">Penilaian Kehadiran Dosen</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h3 class="collapse-header">Menu</h3>
                        <a class="collapse-item collapse-item active" href="{{ route('evaluasi.index') }}">Evaluasi
                            Kehadiran <br>Dosen</a>
                        <a class="collapse-item collapse-item active"
                            href="{{ route('monitoring_kehadiran.index') }}">Monitoring Kehadiran
                            <br>Dosen</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
                    aria-expanded="true" aria-controls="collapseUtilities2">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span style="font-size: 12px !important;">Hasil</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h3 class="collapse-header">Menu</h3>
                        <a class="collapse-item collapse-item active"
                            href="{{ route('hasil-evaluasi-kehadiran') }}">Hasil Evaluasi
                            <br>Kehadiran</a>
                        <a class="collapse-item collapse-item active"
                            href="{{ route('hasil-rekapitulasi-kehadiran') }}">Hasil Monitoring
                            <br>Kehadiran
                        </a>
                    </div>
                </div>
            </li>
            @endif
            {{-- @if (auth()->user()->level == 'Admin')
            <li class="nav-item">
                <a class="nav-link" href="/laporan">
                    <i class="fas fa-fw fa-download"></i>
                    <span>Laporan</span></a>
            </li>
            @endif --}}


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-Secondary topbar mb-4 static-top shadow">
                    <li
                        class="nav-item d-none d-sm-inline-block form-inline p-2 no-arrow d-sm-none badge badge-primary">
                        <!-- Dropdown - Messages -->
                        <div>
                            Tahun Ajaran:
                            {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran .' '. $tahunAjaranAktif->ganjil_genap : 'Tidak Ada' }}
                        </div>
                    </li>

                    <!-- Topbar Search -->

                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <!-- <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div> -->
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"
                                    style="color:blue;">{{ auth()->user()->name }}</span>
                                <i class="fas fa-user-circle fa-2x" style="color: blue;"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    AKUN
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="brand-text font-weight-bold"
                                            style="color:blue;">{{ auth()->user()->name }}</span><br>
                                        <span class="brand-text font-weight-bold"
                                            style="color:blue;">{{ auth()->user()->email }}</span>
                                    </div>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-user-lock text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold">Ubah Kata Sandi</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" id="logoutModal" href="/login">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-sign-out-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold">Logout</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                        Alerts</a>
                            </div>
                        </li>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <footer class="sticky bg-white">
                <div class="container my-2">
                    <div class="copyright text-center my-auto ">
                        <span><b>SPK Dosen Terbaik</b></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script src="{{ asset('SB2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('SB2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('SB2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('SB2/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(function() {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "scrollY": "500px",
            "pageLength": 10,
            "autoWidth": true,
        });
    });
    </script> @section('js')
    @show
</body>

</html>