<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Dosen;
use App\Models\Kriteria;
use App\Models\Evaluasimhs;
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
        ->join('kriteria', 'kriteria.id', '=', 'penilaian.id_kriteria')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        ->groupBy('nama_dosen')
        ->get();
        return view('nilai.index')->with('penilaian', $penilaian);
    }

    public function create()
    {
        // return view('nilai.create');
        $nilai = Nilai::orderBy('id', 'ASC')->get();
        $dosen = Dosen::all();
        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Mahasiswa')
        ->get();
        $mahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->get();
        
        return view('nilai.create',compact(['nilai', 'dosen', 'kriteria', 'mahasiswa']));;
    }

    public function show($id)
    {
        // return view('nilai.create');
        $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        $dosen = Dosen::find($id);
        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Mahasiswa')
        ->get();
        $mahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->get();

        $penilaian = DB::table('penilaian')
        ->selectRaw("*, dosen.nama as nama_dosen")
        ->selectRaw("mahasiswa.nama as nama_mahasiswa")
        ->join('kriteria', 'kriteria.id', '=', 'penilaian.id_kriteria')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        ->where('dosen.id', $id)
        ->groupBy('nama_dosen', 'nama_mahasiswa')
        ->get();

        $penilaian2 = DB::table('penilaian')
        ->selectRaw("*, dosen.nama as nama_dosen")
        ->selectRaw("mahasiswa.nama as nama_mahasiswa")
        ->join('kriteria', 'kriteria.id', '=', 'penilaian.id_kriteria')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'penilaian.id_mahasiswa')
        ->join('dosen', 'dosen.id', '=', 'penilaian.id_dosen')
        ->where('dosen.id', $id)
        ->get();

        return view('nilai.show',compact(['nilai', 'dosen', 'kriteria', 'mahasiswa', 'penilaian', 'penilaian2']));;
    }

    public function store(Request $request)
    {
        // Nilai::create($request->except(['_token','submit']));

        $simpan = [
            'id' => $request->id,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'id_mahasiswa' => $request->id_mahasiswa,
            'id_dosen' => $request->id_dosen
        ];
        Nilai::insert($simpan);
        for ($i = 1; $i < count($request->id_kriteria); $i++) {
            $simpan[] = [
                'id_kriteria' => $request->id_kriteria[$i],
                'jawaban' => $request->jawaban[$i],
                'pengguna' => $request->pengguna[$i],
                'id_penilaian' => $request->id
            ];
            Evaluasimhs::insert($simpan);
        }

        return redirect('/nilai/create');
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