<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Evaluasimhs;
use App\Models\Kriteria;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\Perkuliahan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        $semester = $request->input('semester');
        $perkuliahans = collect();

        if ($semester) {
            $perkuliahans = Perkuliahan::with(['dosen', 'matkul', 'nilai' => function ($query) {
                $query->where('nim', Auth::user()->mahasiswa->nim);
            }])
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->whereHas('matkul', function ($query) use ($semester) {
                    $query->where('smt', $semester);
                })
                ->get();
        }

        return view('penilaian.index', compact('perkuliahans', 'semester', 'tahunAjaranAktif'));
    }


    public function penilaianKRS(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        $userEmail = Auth::user()->email;
        $mahasiswa = Mahasiswa::where('email', $userEmail)->first();
        $semester = $this->hitungSemester($mahasiswa->nim, $tahunAjaranAktif);

        // Mengecek KRS mahasiswa untuk tahun ajaran aktif
        $krs = Krs::where('nim', $mahasiswa->nim)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();

        // Jika tidak ada KRS, kembalikan ke halaman sebelumnya
        if (!$krs) {
            return back()->with('error', 'KRS tidak ditemukan.');
        }

        // Mendapatkan detail KRS untuk perkuliahan yang dipilih
        $krsDetails = KrsDetail::where('krs_id', $krs->id)->pluck('perkuliahan_id');

        // Mendapatkan perkuliahan yang ada di KRS detail
        $perkuliahans = Perkuliahan::with(['dosen', 'matkul', 'nilai' => function ($query) use ($mahasiswa) {
            $query->where('nim', $mahasiswa->nim);
        }])
            ->whereIn('id', $krsDetails)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            // ->whereHas('matkul', function ($query) use ($semester) {
            //     $query->where('smt', $semester);
            // })
            ->get();

        $data = [
            'krsCount' => 1,
            'krsValidated' => $krs->is_validated,
            'currentSemester' => $semester,
        ];

        return view('penilaian.krs', compact('perkuliahans', 'semester', 'tahunAjaranAktif', 'data'));
    }


    public function hitungSemester($nim, $tahunAjaranAktif)
    {
        $angkatan = substr($nim, 0, 2);
        $tahunMulai = (int)$angkatan + 2000;
        $tahunSekarang = (int)substr($tahunAjaranAktif->tahun_ajaran, 0, 4);
        $jumlahTahun = $tahunSekarang - $tahunMulai;
        $semester = ($jumlahTahun * 2) + ($tahunAjaranAktif->ganjil_genap == 'Ganjil' ? 1 : 2);

        return $semester;
    }

    public function beriNilai($id)
    {
        $perkuliahan = Perkuliahan::findOrFail($id);
        $kriteria = DB::table('kriteria')
            ->where('pengguna', 'Mahasiswa')
            ->get();
        return view('penilaian.beri-nilai', compact('perkuliahan', 'kriteria'));
    }

    public function store(Request $request)
    {
        $activeTahunAjaran = TahunAjaran::getActiveTahunAjaran();
        if (!$activeTahunAjaran) {
            return redirect()->route('perkuliahan.index')->with('error', 'No active Tahun Ajaran found.');
        }

        $tahun_ajaran_id = $activeTahunAjaran->id;

        DB::transaction(function () use ($request, $tahun_ajaran_id) {
            $penilaian = Nilai::create([
                'tanggal_penilaian' => now(),
                'nim' => $request->nim,
                'nidn' => $request->id_dosencari,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'perkuliahan_id' => $request->perkuliahan_id,
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            $evaluasiData = [];
            for ($i = 0; $i < count($request->id_kriteria); $i++) {
                $evaluasiData[] = [
                    'jawaban' => $request->jawaban[$i],
                    'pengguna' => 'Mahasiswa',
                    'id_penilaian' => $penilaian->id,
                    'id_kriteria' => $request->id_kriteria[$i]
                ];
            }

            Evaluasimhs::insert($evaluasiData);

        });

        $redirectRoute = $request->input('source') == 'krs' ? 'penilaian.krs' : 'penilaian.index';

        return redirect()->route('penilaian.krs')->with(['success' => 'Terimakasih Sudah Melakukan Penilaian Kepada Dosen']);
    }

   

    public function hasilPenilaianPerSemester($semester)
{
    $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
    $kriteria = Kriteria::all();

    $perkuliahan = DB::table('perkuliahan')
        ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
        ->get();

    $k1_perkuliahan_rank = $this->calculateAndStoreRanks($perkuliahan, $kriteria);

    $mahasiswa = Mahasiswa::all();
    $totalMahasiswa = 0;
    foreach ($mahasiswa as $mhs) {
        if ($this->hitungSemester($mhs->nim, $tahunAjaranAktif) == $semester) {
            $totalMahasiswa++;
        }
    }

    $totalPenilai = DB::table('penilaian')
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
        ->join('perkuliahan', 'perkuliahan.id', '=', 'penilaian.perkuliahan_id')
        ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
        ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
        ->where('penilaian.tahun_ajaran_id', $tahunAjaranAktif->id)
        ->distinct('penilaian.nim')
        ->count('penilaian.nim');

    $dataRank = DB::table('rank as ranks')
        ->selectRaw('ranks.*, dosen.nama, dosen.gelar, matakuliah.nama as nama_matakuliah')
        ->join('perkuliahan', 'perkuliahan.id', '=', 'ranks.perkuliahan_id')
        ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
        ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
        ->orderByRaw('ranks.rank DESC')
        ->get();

    $totalBelumMenilai = $totalMahasiswa - $totalPenilai;

    return view('penilaian.hasil-semester', compact('semester', 'totalMahasiswa', 'totalPenilai', 'totalBelumMenilai', 'dataRank'));
}

private function calculateAndStoreRanks($perkuliahan, $kriteria)
{
    $k1_ambil_mhs = [];
    $k1_ambil_upm = [];
    $totalPenilaianPerPerkuliahan_mhs = [];
    $totalPenilaianPerPerkuliahan_upm = [];

    foreach ($perkuliahan as $s) {
        foreach ($kriteria as $sub) {
            if ($sub->pengguna == 'Mahasiswa') {
                $penilaian_mahasiswa = DB::table('evaluasimhs')
                    ->selectRaw('AVG(evaluasimhs.jawaban) as jumlah')
                    ->join('penilaian', 'penilaian.id', '=', 'evaluasimhs.id_penilaian')
                    ->where('penilaian.perkuliahan_id', $s->id)
                    ->where('evaluasimhs.id_kriteria', $sub->id)
                    ->where('evaluasimhs.pengguna', 'Mahasiswa')
                    ->first();

                $totalPenilaian_mahasiswa = $penilaian_mahasiswa->jumlah ?: 0;
                if ($totalPenilaian_mahasiswa > 0) {
                    $totalPenilaianPerPerkuliahan_mhs[$s->id][$sub->id] = $totalPenilaian_mahasiswa;
                    $k1_ambil_mhs[$sub->id][] = $totalPenilaian_mahasiswa;
                }
            } elseif ($sub->pengguna == 'Admin') {
                $penilaian_upm = DB::table('evaluasiupm_detail')
                    ->selectRaw('AVG(evaluasiupm_detail.jawaban) as jumlah')
                    ->join('evaluasiupm', 'evaluasiupm.id', '=', 'evaluasiupm_detail.evaluasi_id')
                    ->where('evaluasiupm.perkuliahan_id', $s->id)
                    ->where('evaluasiupm_detail.kriteria_id', $sub->id)
                    ->first();

                $totalPenilaian_upm = $penilaian_upm->jumlah ?: 0;
                if ($totalPenilaian_upm > 0) {
                    $totalPenilaianPerPerkuliahan_upm[$s->id][$sub->id] = $totalPenilaian_upm;
                    $k1_ambil_upm[$sub->id][] = $totalPenilaian_upm;
                }
            }
        }
    }

    $k1_normalisasi_mhs = [];
    $k1_normalisasi_upm = [];
    $k1_perkuliahan_rank_mhs = [];
    $k1_perkuliahan_rank_upm = [];

    foreach ($perkuliahan as $sa) {
        $perkuliahan_id = $sa->id;
        if (!isset($k1_perkuliahan_rank_mhs[$perkuliahan_id])) {
            $k1_perkuliahan_rank_mhs[$perkuliahan_id] = 0;
        }
        if (!isset($k1_perkuliahan_rank_upm[$perkuliahan_id])) {
            $k1_perkuliahan_rank_upm[$perkuliahan_id] = 0;
        }

        foreach ($kriteria as $s) {
            if ($s->pengguna == 'Mahasiswa' && isset($totalPenilaianPerPerkuliahan_mhs[$perkuliahan_id][$s->id])) {
                $nilaiMin = !empty($k1_ambil_mhs[$s->id]) ? min($k1_ambil_mhs[$s->id]) : 0;
                $nilaiMax = !empty($k1_ambil_mhs[$s->id]) ? max($k1_ambil_mhs[$s->id]) : 0;

                if ($s->tipe == 'Cost') {
                    $totalPenilaian_mhs = $nilaiMin / ($totalPenilaianPerPerkuliahan_mhs[$perkuliahan_id][$s->id] ?: 1);
                } else {
                    $totalPenilaian_mhs = ($totalPenilaianPerPerkuliahan_mhs[$perkuliahan_id][$s->id] ?: 1) / $nilaiMax;
                }

                $k1_normalisasi_mhs[$s->id][] = $totalPenilaian_mhs;
                $k1_perkuliahan_rank_mhs[$perkuliahan_id] += $totalPenilaian_mhs * $s->bobot;
            } elseif ($s->pengguna == 'Admin' && isset($totalPenilaianPerPerkuliahan_upm[$perkuliahan_id][$s->id])) {
                $nilaiMin = !empty($k1_ambil_upm[$s->id]) ? min($k1_ambil_upm[$s->id]) : 0;
                $nilaiMax = !empty($k1_ambil_upm[$s->id]) ? max($k1_ambil_upm[$s->id]) : 0;

                if ($s->tipe == 'Cost') {
                    $totalPenilaian_upm = $nilaiMin / ($totalPenilaianPerPerkuliahan_upm[$perkuliahan_id][$s->id] ?: 1);
                } else {
                    $totalPenilaian_upm = ($totalPenilaianPerPerkuliahan_upm[$perkuliahan_id][$s->id] ?: 1) / $nilaiMax;
                }

                $k1_normalisasi_upm[$s->id][] = $totalPenilaian_upm;
                $k1_perkuliahan_rank_upm[$perkuliahan_id] += $totalPenilaian_upm * $s->bobot;
            }
        }
    }

    $k1_perkuliahan_rank = [];

    foreach ($perkuliahan as $sa) {
        $perkuliahan_id = $sa->id;
        $rank_mhs = $k1_perkuliahan_rank_mhs[$perkuliahan_id] ?? 0;
        $rank_upm = $k1_perkuliahan_rank_upm[$perkuliahan_id] ?? 0;

        if ($rank_mhs != 0 || $rank_upm != 0) {
            $k1_perkuliahan_rank[$perkuliahan_id] = $rank_mhs + $rank_upm;

            DB::table('rank')->updateOrInsert(
                ['perkuliahan_id' => $perkuliahan_id],
                [
                    'rank' => $rank_mhs + $rank_upm,
                    'rank_mhs' => $rank_mhs,
                    'rank_upm' => $rank_upm,
                    'updated_at' => now(),
                ]
            );
        }
    }

    return $k1_perkuliahan_rank;
}





    





    // public function hasilPenilaianPerSemester($semester)
    // {
    //     $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

    //     // Ambil data penilaian berdasarkan semester
    //     $penilaian = DB::table('penilaian')
    //         ->selectRaw("*, dosen.nama as nama_dosen")
    //         ->selectRaw("penilaian.id as id_pen, matakuliah.nama as nama_matkul, rank.rank as total_rank")
    //         ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
    //         ->join('perkuliahan', 'perkuliahan.id', '=', 'penilaian.perkuliahan_id')
    //         ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
    //         ->join('rank', 'rank.id_dosen', '=', 'penilaian.id_dosen')
    //         ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
    //         ->where('penilaian.tahun_ajaran_id', $tahunAjaranAktif->id)
    //         ->where('matakuliah.smt', $semester)
    //         ->groupBy('nama_dosen')
    //         ->orderBy('rank.rank', 'DESC')
    //         ->get();

    //     // Ambil data untuk donut chart
    //     $totalMahasiswa = Mahasiswa::whereRaw('LEFT(nim, 2) + 2000 <= ?', [$tahunAjaranAktif->tahun_ajaran])->count();
    //     $totalPenilai = DB::table('penilaian')
    //         ->join('mahasiswa', 'mahasiswa.nim', '=', 'penilaian.nim')
    //         ->join('perkuliahan', 'perkuliahan.id', '=', 'penilaian.perkuliahan_id')
    //         ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
    //         ->where('penilaian.tahun_ajaran_id', $tahunAjaranAktif->id)
    //         ->where('matakuliah.smt', $semester)
    //         ->count();

    //     return view('penilaian.hasil-semester', compact('penilaian', 'semester', 'totalMahasiswa', 'totalPenilai'));
    // }





    public function tabelHasilPenilaianPerSemester($semester)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
    
        $dataRank = DB::table('rank as ranks')
            ->selectRaw('ranks.*, dosen.nama, dosen.nidn, dosen.gelar, matakuliah.nama as nama_matakuliah')
            ->join('perkuliahan', 'perkuliahan.id', '=', 'ranks.perkuliahan_id')
            ->join('dosen', 'dosen.nidn', '=', 'perkuliahan.nidn')
            ->join('matakuliah', 'matakuliah.kode', '=', 'perkuliahan.kode')
            ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('matakuliah.smt', $semester)
            ->orderByRaw('ranks.rank DESC')
            ->get();
    
        $chartLabels = $dataRank->pluck('nama_matakuliah');
        $chartData = $dataRank->pluck('rank');
    
        return view('penilaian.tabel-hasil', compact('dataRank', 'semester', 'chartLabels', 'chartData'));
    }
    



    public function indexPerDosen()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

        if ($tahunAjaranAktif) {
            $dosenPerkuliahan = Perkuliahan::with('dosen')
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->get()
                ->groupBy('dosen.nidn');

            return view('penilaian.index-per-dosen', compact('dosenPerkuliahan', 'tahunAjaranAktif'));
        }

        return redirect()->to('beranda');
    }

    public function indexAdmin(Request $request)
{
    $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

    if ($tahunAjaranAktif) {
        $dosenNidn = $request->query('dosen_nidn');
        $dosen = Dosen::where('nidn', $dosenNidn)->first();

        $perkuliahan = Perkuliahan::with(['matkul'])
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('nidn', $dosenNidn)
            ->get();

        $data = [];
        foreach ($perkuliahan as $item) {
            $jumlahMahasiswa = KrsDetail::where('perkuliahan_id', $item->id)->count();
            $jumlahMahasiswaMemilih = Nilai::where('perkuliahan_id', $item->id)->distinct('nim')->count('nim');
            $rank = DB::table('rank')
                ->where('perkuliahan_id', $item->id)
                ->value('rank') ?? 0;

            $data[] = [
                'perkuliahan' => $item,
                'jumlahMahasiswa' => $jumlahMahasiswa,
                'jumlahMahasiswaMemilih' => $jumlahMahasiswaMemilih,
                'rank' => $rank,
            ];
        }

        return view('penilaian.indexadmin', compact('data', 'tahunAjaranAktif', 'dosen'));
    }

    return redirect()->to('beranda');
}



    public function lihatHasilTahunAjaran($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $dosenPerkuliahan = Perkuliahan::with('dosen')
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->get()
                ->groupBy('dosen.nidn');


        return view('penilaian.hasil_tahunajaran', compact('dosenPerkuliahan', 'tahunAjaran'));
    }

    public function indexAdminSemester()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if ($tahunAjaranAktif) {
            $ganjilGenap = $tahunAjaranAktif->ganjil_genap == 'Ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];
            return view('penilaian.indexadminsemester', compact('ganjilGenap'));
        }

        return redirect()->to('beranda');
    }

    public function getCoursesByAdminSemester($semester)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        $penilaian = Nilai::with(['dosen', 'mahasiswa', 'perkuliahan.matkul'])
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->whereHas('perkuliahan.matkul', function ($query) use ($semester) {
                $query->where('smt', $semester);
            })
            ->get()
            ->groupBy('perkuliahan.id');

        return view('penilaian.indexadmin', compact('penilaian', 'semester'));
    }

    public function show($id)
    {
        $perkuliahan = Perkuliahan::with([
            'nilai' => function ($query) {
                $query->with(['evaluasimhs.kriteria', 'mahasiswa']);
            },
            'matkul',
            'dosen',
            'tahunAjaran'
        ])->findOrFail($id);
    
        $jumlahMahasiswa = KrsDetail::where('perkuliahan_id', $id)->count();
        $jumlahMahasiswaMemilih = Nilai::where('perkuliahan_id', $id)->distinct('nim')->count('nim');
    
        return view('penilaian.show', compact('perkuliahan', 'jumlahMahasiswa', 'jumlahMahasiswaMemilih'));
    }    
}
