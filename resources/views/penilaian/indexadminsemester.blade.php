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
                    <h6 class="m-0 font-weight-bold text-primary">Pilih Semester</h6>
                    <div class="mb-4"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @foreach ($ganjilGenap as $semester)
                        
                            <a href="{{ route('penilaian.admin.hasil.semester', $semester) }}" class="btn btn-primary btn-sm m-2">
                                Semester {{ $semester }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
