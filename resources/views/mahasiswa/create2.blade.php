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
    <link href="{{asset('SB2/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('SB2/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>
<style>
#form1 {
    border-width: 2px;
    border-left-color: #00CED1;
    border-right-color: #00CED1;
}
</style>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <img src="{{asset('/template/frontend/images/banner-login.png')}}" class="col-lg-5" alt="image"
                        alt="image" height="680"></i>
                    <div class="col-lg-6">
                        <div class="p-4"><br><br>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1><br><br>
                            </div>
                            <form action="/mahasiswa/store" method="post">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <input id="form1" type="text" class="form-control" name="nama"
                                            placeholder="Masukan Nama">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input id="form1" type="text" class="form-control" name="tempatlahir"
                                            placeholder="Masukan Tempat Lahir">
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="form1" type="date" class="form-control" name="tanggallahir"
                                            placeholder="Masukan Tanggal Lahir">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input id="form1" type="email" class="form-control" name="email"
                                        placeholder="Masukkan Email">
                                </div>
                                <div>
                                    <div class="form-group">
                                        <input id="form1" type="password" class="form-control" name="password"
                                            placeholder="Masukkan Kata Sandi">
                                    </div>
                                </div><br>
                                <a href="/login" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </a><br><br>
                                <div class="text-center">
                                    <a class="small" href="login.html">Already have an account? Login!</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>