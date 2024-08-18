<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkuliahan;
use App\Models\TahunAjaran;
use App\Models\MonitoringKehadiran;
use Illuminate\Support\Facades\DB;

class MonitoringKehadiranController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();
        
        $kategori = $request->get('kategori', '1_3'); // Default filter 1_3
        list($minPertemuan, $maxPertemuan) = explode('_', $kategori);
        
        if ($tahunAjaranAktif) {
            $perkuliahanGroupedByDosen = Perkuliahan::with(['dosen', 'matkul', 'monitoringKehadiran' => function ($query) use ($minPertemuan, $maxPertemuan) {
                $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
            }])
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->get()
                ->groupBy('dosen.nidn');

            return view('monitoring_kehadiran.index', compact('perkuliahanGroupedByDosen', 'tahunAjaranAktif', 'kategori'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }
            
    
    public function checkPrevious(Request $request)
    {
        $perkuliahanId = $request->input('perkuliahan_id');
        $kategori = $request->input('kategori');
    
        if (is_null($perkuliahanId) || is_null($kategori)) {
            return response()->json(['exists' => false], 400);
        }
    
        if (!preg_match('/^\d+_\d+$/', $kategori)) {
            return response()->json(['exists' => false], 400);
        }
    
        $exists = MonitoringKehadiran::where('perkuliahan_id', $perkuliahanId)
            ->where('kategori', $kategori)
            ->exists();
    
        return response()->json(['exists' => $exists]);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'perkuliahan_id' => 'required|exists:perkuliahan,id',
            'kategori' => 'required|string',
            'jumlah_pertemuan' => 'required|integer|min:1|max:15'
        ]);
    
        MonitoringKehadiran::updateOrCreate(
            ['perkuliahan_id' => $data['perkuliahan_id'], 'kategori' => $data['kategori']],
            ['jumlah_pertemuan' => $data['jumlah_pertemuan']]
        );
    
        return redirect()->back()->with('success', 'Data kehadiran berhasil disimpan.');
    }
    
    public function rekapitulasi(Request $request)
{
    
    $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();
        
    $kategori = $request->get('kategori', '1_3'); // Default filter 1_3
    list($minPertemuan, $maxPertemuan) = explode('_', $kategori);
    
    if ($tahunAjaranAktif) {
        $perkuliahanGroupedByDosen = Perkuliahan::with(['dosen', 'matkul', 'monitoringKehadiran' => function ($query) use ($minPertemuan, $maxPertemuan) {
            $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
        }])
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get()
            ->groupBy('dosen.nidn');

        return view('monitoring_kehadiran.rekapitulasi', compact('perkuliahanGroupedByDosen', 'tahunAjaranAktif', 'kategori'));
    }

    return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
}


public function hasilRekapitulasi(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();
        
        $kategori = $request->get('kategori', '1_3'); // Default filter 1_3
        list($minPertemuan, $maxPertemuan) = explode('_', $kategori);
        
        if ($tahunAjaranAktif) {
            $perkuliahanGroupedByDosen = Perkuliahan::with(['dosen', 'matkul', 'monitoringKehadiran' => function ($query) use ($minPertemuan, $maxPertemuan) {
                $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
            }])
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->whereHas('monitoringKehadiran', function ($query) use ($minPertemuan, $maxPertemuan) {
                    $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
                })
                ->get()
                ->groupBy('dosen.nidn');

            return view('monitoring_kehadiran.hasil-rekapitulasi', compact('perkuliahanGroupedByDosen', 'tahunAjaranAktif', 'kategori'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }
    
    public function cetakRekapitulasi(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', 'Aktif')->first();
        
        $kategori = $request->get('kategori', '1_3'); // Default filter 1_3
        list($minPertemuan, $maxPertemuan) = explode('_', $kategori);
        
        if ($tahunAjaranAktif) {
            $perkuliahanGroupedByDosen = Perkuliahan::with(['dosen', 'matkul', 'monitoringKehadiran' => function ($query) use ($minPertemuan, $maxPertemuan) {
                $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
            }])
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->whereHas('monitoringKehadiran', function ($query) use ($minPertemuan, $maxPertemuan) {
                    $query->whereBetween('jumlah_pertemuan', [$minPertemuan, $maxPertemuan]);
                })
                ->get()
                ->groupBy('dosen.nidn');

            return view('monitoring_kehadiran.cetak-rekapitulasi', compact('perkuliahanGroupedByDosen', 'tahunAjaranAktif', 'kategori'));
        }

        return redirect()->to('beranda')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    }


    
}
