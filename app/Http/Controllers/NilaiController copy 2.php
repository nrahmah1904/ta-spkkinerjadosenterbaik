<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Evaluasiupm;
use App\Models\Dosen;
use App\Models\Evaluasimhs;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        // $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        // $kriteria = Kriteria::all();

        $penilaian = DB::table('penilaian')
        ->selectRaw("*, dosen.nama as nama_dosen")
        ->selectRaw("penilaian.id as id_pen")
        ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        ->groupBy('nama_dosen')
        ->get();
        return view('nilai.index')->with('penilaian', $penilaian);
    }

    public function proses($id)
    {
        // return view('nilai.create');
        $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        $dosen = Dosen::find($id);

        // $dosen = DB::table('penilaian')
        // ->selectRaw("*, dosen.nama as nama_dosen")
        // ->selectRaw("penilaian.id as id_pen")
        // ->selectRaw("mahasiswa.nama as nama_mahasiswa")
        // ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        // ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        // ->where('dosen.id', $id)
        // ->get();

        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Admin')
        ->get();
        
        return view('nilai.proses',compact(['nilai', 'dosen', 'kriteria']));;
    }

    public function create()
    {
        // return view('nilai.create');
        $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Mahasiswa')
        ->get();
        $mahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->get();


        
        $matakuliah = DB::table('dosen')
        ->selectRaw("*, dosen.id as id_dosen")
        ->join("matakuliah", "dosen.id_matakuliah", "=", "matakuliah.id")
        ->get();

        $dataMahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->first();
        $dataMahasiswa = (array) $dataMahasiswa;

        $dosenSudah = DB::table("penilaian")
        ->selectRaw("*")
        ->where("id_mahasiswa", "=", $dataMahasiswa['id'])
        ->get();

        $arrDosen = [];
        foreach ($dosenSudah as $keys => $values) {
            $values = (array) $values;
            $arrDosen[$values['id_dosen']] = $values['id_dosen'];
        }
        $arrDosen = array_values($arrDosen);

        $sqlDosen = DB::table("dosen")
        ->selectRaw("*");

        $sqlDosen = DB::table('dosen')
        ->selectRaw("*")
        ->groupByRaw("dosen.nidn");

        if(isset($arrDosen) && !empty($arrDosen)) {
            $implodeDosen = implode(", ", $arrDosen);
            $sqlDosen->whereRaw("id NOT IN(".$implodeDosen.")");
        }

        $dosen = $sqlDosen->get();

        $sqlDosen = DB::table('dosen')
        ->selectRaw("*")
        ->groupByRaw("dosen.nidn");
        $dosen = $sqlDosen->get();
        
        $startYear = 2015;
        $endYear = 2024;
        
        $tahunajaran = [];
        for ($year = $startYear; $year < $endYear; $year++) {
            $tahunajaran[] = $year . '-' . ($year + 1);
        }

        $nowtahunajaran = date('Y')."-".date('Y', strtotime(date('Y')."+1year"));

        return view('nilai.create',compact(['nilai', 'dosen', 'kriteria', 'mahasiswa', 'matakuliah', 'tahunajaran', 'nowtahunajaran']));;
    }

    public function show($id)
    {
        // return view('nilai.create');
        // $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        $nilai = Nilai::find($id);
        $dosen = Dosen::find($id);
        // $dosen = Dosen::find($id);
        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Mahasiswa')
        ->get();
        $mahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->get();

        $penilaian = DB::table('penilaian')
        ->selectRaw("*, dosen.nama as nama_dosen")
        ->selectRaw("penilaian.id as id_pen")
        ->selectRaw("mahasiswa.nama as nama_mahasiswa")
        ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        ->where('dosen.id', $id)
        ->get();

        // $penilaian2 = DB::table('evaluasimhs')
        // ->join('kriteria', 'kriteria.id', '=', 'evaluasimhs.id_kriteria')
        // ->join('penilaian', 'penilaian.id', '=', 'evaluasimhs.id_penilaian')
        // ->where('penilaian.id', $id)
        // ->get();

        return view('nilai.show',compact(['nilai', 'dosen', 'kriteria', 'mahasiswa', 'penilaian']));;
    }

    public function store(Request $request)
    {
        // Nilai::create($request->except(['_token','submit']));
        $simpan1 = [
            'id' => $request->id,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'id_mahasiswa' => $request->id_mahasiswa,
            'id_dosen' => $request->id_dosen,
            'id_matakuliah' => $request->id_matakuliah,
            'tahun_ajaran' => $request->tahun_ajaran
        ];
        Nilai::insert($simpan1);
        for ($i = 0; $i < count($request->id_kriteria); $i++) {
            $simpan2[] = [
                'jawaban' => $request->jawaban[$i],
                'pengguna' => $request->pengguna[$i],
                'id_penilaian' => $request->id,
                'id_kriteria' => $request->id_kriteria[$i]
            ];
        }
        Evaluasimhs::insert($simpan2);

        return redirect()->route('nilai.create')->with(['success' => 'Terimakasih Sudah Melakukan Penilaian Kepada Dosen']);
    }


    public function store2(Request $request)
    {
        // Nilai::create($request->except(['_token','submit']));
        $simpan1 = [
            'id' => $request->id,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'id_dosen' => $request->id_dosen,
            'id_matakuliah' => $request->id_matakuliah,
            'tahun_ajaran' => $request->tahun_ajaran
        ];
        Evaluasiupm::insert($simpan1);

        for ($i = 0; $i < count($request->id_kriteria); $i++) {
            $simpan2[] = [
                'jawaban' => $request->jawaban[$i],
                'pengguna' => $request->pengguna[$i],
                'id_penilaian' => $request->id,
                'id_kriteria' => $request->id_kriteria[$i]
            ];
        }
        Evaluasimhs::insert($simpan2);

        return redirect('/nilai');
    }

    public function edit($id)
    {
        $nilai = Nilai::find($id);
        return view('nilai.edit',compact(['nilai']));
    }

    public function update($id, Request $request)
    {
        $nilai = Nilai::find($id);
        $nilai->update($request->except(['_token','submit']));
        return redirect('/nilai');
    }

}