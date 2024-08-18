<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Perkuliahan;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->level == 'Admin') {
            $krsEntries = Krs::with('detail.perkuliahan.matkul', 'mahasiswa', 'tahunAjaran')->get();
        } else {
            $mahasiswaId = $user->mahasiswa->nim;
            $krsEntries = Krs::with('detail.perkuliahan.matkul')->where('nim', $mahasiswaId)->get();
        }

        return view('krs.index', compact('krsEntries'));
    }

    public function create()
    {
        $mahasiswaId = Auth::user()->mahasiswa->nim;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $semester = $this->hitungSemester(Auth::user()->mahasiswa->nim, $tahunAjaranAktif);

        // $perkuliahanEntries = Perkuliahan::where('tahun_ajaran_id', $tahunAjaranAktif->id)
        //     ->whereHas('matkul', function ($query) use ($semester) {
        //         $query->where('smt', $semester);
        //     })->get();

        $perkuliahanEntries = Perkuliahan::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

        return view('krs.create', compact('perkuliahanEntries', 'tahunAjaranAktif', 'semester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perkuliahan_id' => 'required|array',
            'perkuliahan_id.*' => 'exists:perkuliahan,id',
        ]);

        $mahasiswaId = Auth::user()->mahasiswa->nim;
        $tahunAjaranId = TahunAjaran::where('is_active', true)->value('id');
        $semester = $this->hitungSemester(Auth::user()->mahasiswa->nim, TahunAjaran::where('is_active', true)->first());

        $krs = Krs::create([
            'nim' => $mahasiswaId,
            'tahun_ajaran_id' => $tahunAjaranId,
            'semester' => $semester,
            'is_validated' => false,
        ]);

        foreach ($request->perkuliahan_id as $perkuliahanId) {
            KrsDetail::create([
                'krs_id' => $krs->id,
                'perkuliahan_id' => $perkuliahanId,
            ]);
        }

        return redirect('/krs')->with('success', 'KRS berhasil disimpan dan menunggu validasi');
    }

    public function validateKrs($id)
    {
        $krs = Krs::findOrFail($id);
        $krs->is_validated = true;
        $krs->validated_by = Auth::id();
        $krs->save();

        return redirect('/krs')->with('success', 'KRS berhasil divalidasi');
    }

    private function hitungSemester($nim, $tahunAjaranAktif)
    {
        $tahunMasuk = '20' . substr($nim, 0, 2);
        $tahunSekarang = (int) substr($tahunAjaranAktif->tahun_ajaran, 0, 4);

        $selisihTahun = $tahunSekarang - (int) $tahunMasuk;
        $semester = ($selisihTahun * 2) + ($tahunAjaranAktif->ganjil_genap == 'Ganjil' ? 1 : 2);

        return $semester;
    }
}
