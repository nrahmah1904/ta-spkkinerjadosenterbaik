<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardKaprodiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('kaprodi.dashboard', compact('user'));
    }

    public function dosenTerbaik()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

        if ($tahunAjaranAktif) {
            $dosenTerbaik = DB::table('rank')
            ->join('perkuliahan', 'rank.perkuliahan_id', '=', 'perkuliahan.id')
            ->join('dosen', 'perkuliahan.nidn', '=', 'dosen.nidn')
            ->join('matakuliah', 'perkuliahan.kode', '=', 'matakuliah.kode')
            ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
            ->select('dosen.nidn', 'dosen.nama as nama_dosen', 'matakuliah.kode', 'matakuliah.nama as nama_matakuliah', 'rank.rank')
            ->orderBy('rank.rank', 'desc')
            ->get();

        $highestRank = $dosenTerbaik->first()->rank;
        $dosenTerbaik = $dosenTerbaik->filter(function ($item) use ($highestRank) {
            return $item->rank == $highestRank;
        });

            return view('dosen-terbaik.index', compact('dosenTerbaik', 'tahunAjaranAktif'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }

    public function hasilPemeringkatan()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

        if ($tahunAjaranAktif) {
            $ranking = DB::table('rank')
                ->join('perkuliahan', 'rank.perkuliahan_id', '=', 'perkuliahan.id')
                ->join('dosen', 'perkuliahan.nidn', '=', 'dosen.nidn')
                ->join('matakuliah', 'perkuliahan.kode', '=', 'matakuliah.kode')
                ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
                ->select('dosen.nidn', 'dosen.nama as nama_dosen', 'matakuliah.kode', 'matakuliah.nama as nama_matakuliah', 'rank.rank', 'rank.validasi')
                ->orderBy('rank.rank', 'desc')
                ->get();

            $allValidated = $ranking->every(function ($rank) {
                return $rank->validasi == 1;
            });

            return view('dosen-terbaik.hasil-pemeringkatan', compact('ranking', 'allValidated'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }

    public function validasiRank()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

        if ($tahunAjaranAktif) {
            DB::table('rank')
                ->join('perkuliahan', 'rank.perkuliahan_id', '=', 'perkuliahan.id')
                ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
                ->update(['rank.validasi' => 1]);

            return redirect()->route('hasil-pemeringkatan')->with('success', 'Semua rank berhasil divalidasi.');
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }
    public function cetakLaporan()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();

        if ($tahunAjaranAktif) {
            $ranking = DB::table('rank')
                ->join('perkuliahan', 'rank.perkuliahan_id', '=', 'perkuliahan.id')
                ->join('dosen', 'perkuliahan.nidn', '=', 'dosen.nidn')
                ->join('matakuliah', 'perkuliahan.kode', '=', 'matakuliah.kode')
                ->where('perkuliahan.tahun_ajaran_id', $tahunAjaranAktif->id)
                ->where('rank.validasi', 1)
                ->select('dosen.nidn', 'dosen.nama as nama_dosen', 'matakuliah.kode', 'matakuliah.nama as nama_matakuliah', 'rank.rank')
                ->orderBy('rank.rank', 'desc')
                ->get();

            return view('dosen-terbaik.laporan-cetak', compact('ranking', 'tahunAjaranAktif'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }
}
