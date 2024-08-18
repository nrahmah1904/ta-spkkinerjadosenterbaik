<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Evaluasiupm;
use App\Models\Dosen;
use App\Models\Evaluasimhs;
use App\Models\Kriteria;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        // $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        // $kriteria = Kriteria::all();

        $tahunAjaranAktif = DB::table('tahunajarans')
            ->where('is_active', 'Aktif')
            ->first();

        if ($tahunAjaranAktif) {
            $penilaian = DB::table('penilaian')
                ->selectRaw("penilaian.*, dosen.nidn, dosen.nama as nama_dosen, dosen.gelar, penilaian.id as id_pen")
                ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
                ->join('dosen', 'dosen.nidn', '=', 'penilaian.nidn')
                ->where('penilaian.tahun_ajaran_id', $tahunAjaranAktif->id)
                ->groupBy('nama_dosen')
                ->get();

            return view('nilai.index', compact('penilaian'));
        }
        return redirect()->route('beranda');
    }

    public function laporan()
    {
        $tahunAjarans = TahunAjaran::all();

        return view('nilai.indexlaporan', compact('tahunAjarans'));
    }
    public function proses($id)
    {
        // Mengambil data perkuliahan berdasarkan ID
        $perkuliahan = DB::table('perkuliahan')
            ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
            ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
            ->where('perkuliahan.id', $id)
            ->select('perkuliahan.*', 'matakuliah.nama as nama_matkul', 'matakuliah.kode as kode_matkul', 'matakuliah.sks', 'matakuliah.smt', 'dosen.nama as nama_dosen', 'dosen.nidn')
            ->first();
    
        // Mengambil kriteria yang digunakan oleh Admin
        $kriteria = DB::table('kriteria')
            ->where('pengguna', 'Admin')
            ->get();
    
        // Mengambil evaluasi UPM
        // $evaluasiUpm = DB::table('evaluasiupm')
        //     ->where('perkuliahan_id', $id)
        //     ->get();

            $evaluasiUpm = DB::table('evaluasimhs')
            ->join('evaluasiupm', 'evaluasiupm.id', '=', 'evaluasimhs.id_penilaian')
            ->join('kriteria', 'kriteria.id', '=', 'evaluasimhs.id_kriteria')
            ->where('evaluasiupm.perkuliahan_id', $id)
            ->where('evaluasimhs.pengguna', "Admin")
            ->get();


        return view('nilai.proses', compact('perkuliahan', 'kriteria', 'evaluasiUpm'));
    }
        
        

    public function create()
    {
        $tahunAjaranAktif = DB::table('tahunajarans')
            ->where('is_active', 'Aktif')
            ->first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }



        // return view('nilai.create');
        $nilai = Nilai::orderBy('id', 'ASC')->get();
        // $dosen = Dosen::all();
        // $kriteria = Kriteria::all();
        $kriteria = DB::table('kriteria')
            ->where('pengguna', 'Mahasiswa')
            ->get();
        $mahasiswa = DB::table('mahasiswa')
            ->where('email', session()->get('email'))
            ->first();



        // $dataMahasiswa = DB::table('mahasiswa')
        //     ->where('email', session()->get('email'))
        //     ->first();
        // $dataMahasiswa = (array) $dataMahasiswa;

        // $matakuliahSudah = DB::table("penilaian")
        //     ->selectRaw("*")
        //     ->join("dosen", "penilaian.nidn", "=", "dosen.nidn")
        //     ->where("id_mahasiswa", "=", $dataMahasiswa['id'])
        //     ->get();

        // $arrMatakuliah = [];
        // foreach ($matakuliahSudah as $keys => $values) {
        //     $values = (array) $values;
        //     $arrMatakuliah[$values['id_matakuliah']] = $values['id_matakuliah'];
        // }
        // $arrMatakuliah = array_values($arrMatakuliah);

        // $sqlMatakuliah = DB::table('dosen')
        //     ->selectRaw("*, dosen.nidn as nidn")
        //     ->join("matakuliah", "dosen.nidn_matakuliah", "=", "matakuliah.kode");

        // if (isset($arrMatakuliah) && !empty($arrMatakuliah)) {
        //     $implodeMatakuliah = implode(", ", $arrMatakuliah);
        //     $sqlMatakuliah->whereRaw("matakuliah.kode NOT IN(" . $implodeMatakuliah . ")");
        // }

        // $matakuliah = $sqlMatakuliah->get();

        // $dataMahasiswa = DB::table('mahasiswa')
        //     ->where('email', session()->get('email'))
        //     ->first();

        // if ($dataMahasiswa) {
        //     $arrMatakuliah = DB::table('penilaian')
        //         ->join('perkuliahan', 'penilaian.perkuliahan_id', '=', 'perkuliahan.id')
        //         ->join('dosen', 'penilaian.nidn', '=', 'dosen.nidn')
        //         ->where('penilaian.nim', '=', $dataMahasiswa->id)
        //         ->pluck('perkuliahan.id')
        //         ->toArray();

        //     $sqlMatakuliah = DB::table('dosen')
        //         ->select('dosen.*', 'matakuliah.*', 'dosen.nidn as nidn')
        //         ->join('matakuliah', 'dosen.nidn_matakuliah', '=', 'matakuliah.kode');

        //     if (!empty($arrMatakuliah)) {
        //         $sqlMatakuliah->whereNotIn('matakuliah.kode', $arrMatakuliah);
        //     }

        //     $matakuliah = $sqlMatakuliah->get();
        // } else {
        //     $matakuliah = [];
        // }

        $sqlDosen = DB::table('dosen')
            ->selectRaw("*")
            ->groupByRaw("dosen.nidn");

        $dosen = $sqlDosen->get();


        return view('nilai.create', compact(['nilai', 'dosen', 'kriteria', 'mahasiswa']));
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
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
            ->join('dosen', 'dosen.nidn', '=', 'penilaian.nidn')
            ->where('dosen.nidn', $id)
            ->get();

        // $penilaian2 = DB::table('evaluasimhs')
        // ->join('kriteria', 'kriteria.id', '=', 'evaluasimhs.id_kriteria')
        // ->join('penilaian', 'penilaian.id', '=', 'evaluasimhs.id_penilaian')
        // ->where('penilaian.id', $id)
        // ->get();

        return view('nilai.show', compact(['nilai', 'dosen', 'kriteria', 'mahasiswa', 'penilaian']));;
    }
    public function print(Request $request)
{
    $tahun_ajaran = $request->tahun_ajaran_id;
    $detailtahun = DB::table('tahunajarans')
        ->where('id', $tahun_ajaran)
        ->first();
    $kriteria = DB::table('kriteria')
        ->where('pengguna', 'Mahasiswa')
        ->get();
    $mahasiswa = DB::table('mahasiswa')
        ->where('email', session()->get('email'))
        ->get();

    $penilaian = DB::table('penilaian')
        ->selectRaw("*, dosen.nama as nama_dosen")
        ->selectRaw("penilaian.id as id_pen, matakuliah.nama as nama_matkul, rank.rank as total_rank")
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
        ->join('perkuliahan', 'perkuliahan.id', '=', 'penilaian.perkuliahan_id')
        ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
        ->join('rank', 'rank.perkuliahan_id', '=', 'penilaian.perkuliahan_id')
        ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
        ->where('penilaian.tahun_ajaran_id', $tahun_ajaran)
        ->groupBy('perkuliahan.id')
        ->orderBy('rank.rank', 'DESC')
        ->get();

    return view('nilai.print', compact(['kriteria', 'mahasiswa', 'penilaian', 'tahun_ajaran', 'detailtahun']));
}


    public function store(Request $request)
    {
        // Nilai::create($request->except(['_token','submit']));

        $activeTahunAjaran = TahunAjaran::getActiveTahunAjaran();
        if (!$activeTahunAjaran) {
            return redirect()->route('perkuliahan.index')->with('error', 'No active Tahun Ajaran found.');
        }

        $tahun_ajaran_id = $activeTahunAjaran->id;

        $simpan1 = [
            'id' => $request->id,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'id_mahasiswa' => $request->id_mahasiswa,
            'nidn' => $request->nidncari,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'perkuliahan_id' => $request->perkuliahan_id,
            // 'id_matakuliah' => $request->id_matakuliah,
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
        $activeTahunAjaran = TahunAjaran::getActiveTahunAjaran();
        if (!$activeTahunAjaran) {
            return redirect()->route('perkuliahan.index')->with('error', 'No active Tahun Ajaran found.');
        }
    
        $tahun_ajaran_id = $activeTahunAjaran->id;
    
        $simpan1 = [
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'perkuliahan_id' => $request->perkuliahan_id,
            'tahun_ajaran_id' => $tahun_ajaran_id,
            'tahun_ajaran' => $request->tahun_ajaran
        ];
    
        // Menggunakan create untuk mendapatkan instance dari evaluasiupm yang baru dibuat
        $evaluasiupm = Evaluasiupm::create($simpan1);
    
        $simpan2 = [];
        for ($i = 0; $i < count($request->id_kriteria); $i++) {
            $simpan2[] = [
                'jawaban' => $request->jawaban[$i],
                'pengguna' => $request->pengguna[$i],
                'id_penilaian' => $evaluasiupm->id,  
                'id_kriteria' => $request->id_kriteria[$i]
            ];
        }
    
        Evaluasimhs::insert($simpan2);
    
        return redirect('/penilaian/admin');
    }
    

    public function edit($id)
    {
        $nilai = Nilai::find($id);
        return view('nilai.edit', compact(['nilai']));
    }

    public function update($id, Request $request)
    {
        $nilai = Nilai::find($id);
        $nilai->update($request->except(['_token', 'submit']));
        return redirect('/nilai');
    }

    public function getPerkuliahan(Request $request)
    {
        $dosenId = $request->input('nidn');
        $semester = $request->input('semester');
        $mahasiswaId = $request->input('id_mahasiswa');

        $perkuliahan = DB::table('perkuliahan')
            ->join('matakuliah', 'perkuliahan.kode', '=', 'matakuliah.kode')
            ->where('perkuliahan.nidn', $dosenId)
            ->where('matakuliah.smt', $semester)
            ->select('perkuliahan.id as perkuliahan_id', 'matakuliah.nama as matakuliah_nama', 'matakuliah.kode as matakuliah_kode', 'matakuliah.smt')
            ->get();

        $filteredPerkuliahan = $perkuliahan->filter(function ($item) use ($mahasiswaId, $dosenId) {
            $exists = DB::table('penilaian')
                ->where('id_mahasiswa', $mahasiswaId)
                ->where('nidn', $dosenId)
                ->where('perkuliahan_id', $item->perkuliahan_id)
                ->exists();
            return !$exists;
        });

        return response()->json($filteredPerkuliahan);
    }
}
