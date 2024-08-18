<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\Dosen;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SawController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = DB::table('tahunajarans')
            ->where('is_active', 'Aktif')
            ->first();

        if ($tahunAjaranAktif) {
            $dataRank = DB::table('rank as ranks')
                ->selectRaw('ranks.*, dosen.nama, dosen.gelar, dosen.nidn')
                ->selectRaw('matakuliah.nama as nama_matakuliah, matakuliah.kode')
                ->join('perkuliahan', 'perkuliahan.id', '=', 'ranks.perkuliahan_id')
                ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
                ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
                ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
                ->orderBy('ranks.rank', 'DESC')
                ->get();

            return view('saw')->with('dataRank', $dataRank);
        }

        return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
    }


    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        Matakuliah::create($request->except(['_token','submit']));
        return redirect('/matakuliah');
    }
}