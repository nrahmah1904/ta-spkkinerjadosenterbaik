<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('tahunajaran.index', compact('tahunAjarans'));
    }

    public function activate(Request $request, TahunAjaran $tahunajaran)
    {
        TahunAjaran::where('id', '!=', $tahunajaran->id)
            ->where('is_active', 'Aktif')->update(['is_active' => 'Tidak Aktif']);
        $tahunajaran->update(['is_active' => 'Aktif']);
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
    public function activateAgain(TahunAjaran $tahunajaran)
    {
        DB::beginTransaction();
    
        try {
            TahunAjaran::where('is_active', 'Aktif')->update(['is_active' => 'Tidak Aktif']);
            
            $tahunajaran->update(['is_active' => 'Aktif']);
    
            DB::commit();
    
            return redirect()->route('penilaian.index-per-dosen')->with('success', 'Tahun ajaran berhasil diaktifkan kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengaktifkan tahun ajaran.');
        }
    }
    
    public function create()
    {
        return view('tahunajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'ganjil_genap' => 'required',
        ]);

        TahunAjaran::create($request->all());
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function show(TahunAjaran $tahunajaran)
    {
        return view('tahunajaran.show', compact('tahunajaran'));
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::find($id);
        return view('tahunajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunajaran)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'ganjil_genap' => 'required',
        ]);

        if ($request->is_active == 'Aktif') {
            TahunAjaran::where('id', '!=', $tahunajaran->id)
                ->where('is_active', 'Aktif')->update(['is_active' => 'Tidak Aktif']);
        }

        $tahunajaran->update($request->all());
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    public function destroy(TahunAjaran $tahunajaran)
    {
        if ($tahunajaran->is_active == 'Tidak Aktif') {
            $tahunajaran->delete();
            return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
        } else {

            return redirect()->route('tahunajaran.index')->with('error', 'Tahun ajaran yang aktif/terlaksana tidak dapat dihapus.');
        }
    }

    public function periodePenilaianSelesai(Request $request)
    {
        $tahunAjaranAktif = DB::table('tahunajarans')
            ->where('is_active', 'Aktif')
            ->first();

        if ($tahunAjaranAktif) {
            DB::table('tahunajarans')
                ->where('id', $tahunAjaranAktif->id)
                ->update(['is_active' => 'Terlaksana']);

            return redirect()->back()->with('success', 'Periode penilaian telah selesai.');
        }

        return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
    }
}
