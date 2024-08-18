<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Krs;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $data = [];

        if (auth()->user()->level == 'Admin' || auth()->user()->level == 'Upm') {
            $data['mahasiswaCount'] = DB::table('mahasiswa')->count();
            $data['dosenCount'] = DB::table('dosen')->count();
            $data['kriteriaCount'] = DB::table('kriteria')->count();
        } elseif (auth()->user()->level == 'Mahasiswa') {
            $user = Auth::user();
            $mahasiswaId = $user->mahasiswa->nim;
            $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

            if ($tahunAjaranAktif) {
                $krs = Krs::where('nim', $mahasiswaId)
                          ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                          ->first();
                
                if ($krs) {
                    $data['krsCount'] = 1;
                    $data['krsValidated'] = $krs->is_validated;
                    $data['currentSemester'] = $krs->semester;
                } else {
                    $data['krsCount'] = 0;
                    $data['krsValidated'] = false;
                    $data['currentSemester'] = $this->hitungSemester($user->mahasiswa->nim, $tahunAjaranAktif);
                }
            } else {
                $data['krsCount'] = 0;
                $data['krsValidated'] = false;
                $data['currentSemester'] = 0;
            }
        }

        return view('beranda', $data);
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
