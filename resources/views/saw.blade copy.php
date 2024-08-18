@include('master')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Kriteria Penilaian Dosen</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Kriteria</th>
                                <th>Bobot</th>
                                <th>Bobot (Desimal)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px">
                            @foreach($kriteria as $e=>$s)
                        <tbody>
                            <tr>
                                <td>{{$e+1}}</td>
                                <td>{{$s->kode}}</td>
                                <td>{{$s->kriteria}}</td>
                                <td>{{$s->bobot}}</td>
                                <td>{{$s->bobot/100}}</td>
                                <td>{{$s->status}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Penentuan Nilai</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>Gelar</th>
                                @foreach($kriteria as $e=>$s)
                                <th>{{$s->kriteria}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        @php $k1_ambil = []; $totalPenilaianA = []; $totalPenilaianPerDosen = []; @endphp
                        @foreach($penilaian as $e=>$s)
                        <tbody>
                            <tr>
                                <td>{{$e+1}}</td>
                                <td>{{$s->id_dosen}}</td>
                                <td>{{$s->nama}}</td>
                                <td>{{$s->gelar}}</td>
                                @foreach($kriteria as $e=>$sub)
                                @php
                                $tot_jawaban=0;
                                $no=1;
                                $penilaian_mahasiswa = DB::table('evaluasimhs')
                                ->selectRaw('SUM(evaluasimhs.jawaban) as jumlah')
                                ->join('penilaian', 'penilaian.id', '=', 'evaluasimhs.id_penilaian')
                                ->where('penilaian.id_dosen', $s->id_dosen)
                                ->where('evaluasimhs.id_kriteria', $sub->id)
                                ->where('evaluasimhs.pengguna', "Mahasiswa")
                                ->first();
                                $penilaian_admin = DB::table('evaluasimhs')
                                ->selectRaw('SUM(evaluasimhs.jawaban) as jumlah')
                                ->join('evaluasiupm', 'evaluasiupm.id', '=', 'evaluasimhs.id_penilaian')
                                ->where('evaluasiupm.id_dosen', $s->id_dosen)
                                ->where('evaluasimhs.id_kriteria', $sub->id)
                                ->where('evaluasimhs.pengguna', "Admin")
                                ->first();
                                $penilaian_total = $penilaian_mahasiswa->jumlah + $penilaian_admin->jumlah;
                                if(!isset($totalPenilaianA[$e])) {
                                $totalPenilaianA[$e] = 0;
                                }
                                $totalPenilaianA[$e] += $penilaian_total;
                                $totalPenilaianPerDosen[$s->id_dosen][$e] = $penilaian_total;
                                $k1_ambil[$e][] = $penilaian_total;
                                @endphp
                                {{-- <td>{{$sub->kriteria}} </td> --}}
                                <td>{{ $penilaian_total }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                        @endforeach
                        <tr>
                            <th colspan="4">Total Nilai</th>
                            @foreach($kriteria as $e=>$s)
                            @php
                            if ($s->status=="Cost"){
                            @endphp
                            <th>{{min($k1_ambil[$e])}}</th>
                            @php
                            }else{
                            @endphp
                            <th>{{max($k1_ambil[$e])}}</th>
                            @php
                            }
                            @endphp
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header md-12">
                <h5 class="text-center">Penentuan Normalisasi</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>Gelar</th>
                                @foreach($kriteria as $e=>$s)
                                <th>{{$s->kriteria}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        @php
                        $k1_normalisasi = [];
                        $k1_dosen_rank = [];
                        @endphp
                        @foreach($penilaian as $e=>$sa)
                        @php
                        if(!isset($k1_dosen_rank[$sa->id_dosen])) {
                        $k1_dosen_rank[$sa->id_dosen] = 0;
                        }
                        @endphp
                        <tbody>
                            <tr>
                                <td>{{$e+1}}</td>
                                <td>{{$sa->id_dosen}}</td>
                                <td>{{$sa->nama}}</td>
                                <td>{{$sa->gelar}}</td>
                                @foreach($kriteria as $e=>$s)
                                @php
                                if($s->status == "Cost") {
                                if(isset($k1_ambil[$e]) && !empty($k1_ambil[$e])) {
                                $nilaiMin = min($k1_ambil[$e]);
                                if($nilaiMin != 0) {
                                $totalPenilaian = $nilaiMin / $totalPenilaianPerDosen[$sa->id_dosen][$e];
                                }else {
                                $totalPenilaian = $totalPenilaianPerDosen[$sa->id_dosen][$e];
                                }

                                $k1_normalisasi[$e][] = $totalPenilaian;

                                $k1_dosen_rank[$sa->id_dosen] += ($totalPenilaian * $s->bobot);

                                echo "<td>".$totalPenilaian."</td>";
                                }else {
                                $totalPenilaian = $totalPenilaianPerDosen[$sa->id_dosen][$e];

                                $k1_dosen_rank[$sa->id_dosen] += ($totalPenilaian * $s->bobot);

                                echo "<td>".$totalPenilaian."</td>";
                                }
                                }else {
                                if(isset($k1_ambil[$e]) && !empty($k1_ambil[$e])) {
                                $nilaiMax = max($k1_ambil[$e]);
                                if($nilaiMax != 0) {
                                $totalPenilaian = $totalPenilaianPerDosen[$sa->id_dosen][$e] / $nilaiMax;
                                }else {
                                $totalPenilaian = $totalPenilaianPerDosen[$sa->id_dosen][$e];
                                }

                                $k1_normalisasi[$e][] = $totalPenilaian;

                                $k1_dosen_rank[$sa->id_dosen] += ($totalPenilaian * $s->bobot);

                                echo "<td>".$totalPenilaian."</td>";
                                }else {
                                $totalPenilaian = $totalPenilaianPerDosen[$sa->id_dosen][$e];

                                $k1_dosen_rank[$sa->id_dosen] += ($totalPenilaian * $s->bobot);

                                echo "<td>".$totalPenilaian."</td>";
                                }
                                }
                                @endphp
                                @endforeach

                            </tr>
                        </tbody>
                        @endforeach
                        <tr>
                            <th colspan="4">Total Nilai</th>
                            @foreach($kriteria as $e=>$s)
                            @php
                            if ($s->status=="Cost"){
                            @endphp
                            <th>{{min($k1_normalisasi[$e])}}</th>
                            @php
                            }else{
                            @endphp
                            <th>{{max($k1_normalisasi[$e])}}</th>
                            @php
                            }
                            @endphp
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary">
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <h4 class="m-0">Hasil Perhitungan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Kode Dosen</th>
                                <th>Dosen</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        @php
                        $no = 0;
                        DB::table('rank')->truncate();
                        @endphp
                        @foreach($k1_dosen_rank as $index => $m)
                        @php
                        DB::table('rank')->insert([
                        'id_dosen'=>$index,
                        'rank'=>$m,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        $no++;
                        @endphp
                        @endforeach
                        @php
                        $dataRank = DB::table("rank")
                        ->selectRaw("rank.*, dosen.nama, dosen.gelar")
                        ->join('dosen', 'dosen.id', '=', 'rank.id_dosen')
                        ->orderByRaw("rank.rank DESC")
                        ->get();
                        @endphp

                        @foreach($dataRank as $index => $m)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$m->id_dosen}}</td>
                            <td>{{$m->nama}} {{ $m->gelar }}</td>
                            <td>{{$m->rank}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>