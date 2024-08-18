<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Perkuliahan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
    
        if (!$tahunAjaranAktif) {
            return redirect()->to('beranda')->with('error', 'Tidak ada tahun ajaran aktif yang sesuai.');
        }
    
        $perkuliahans = Perkuliahan::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();
    
        return view('perkuliahan.index', compact('perkuliahans'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = Dosen::all();  
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
    
        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif yang sesuai.');
        }
    
        $semesterToDisplay = $tahunAjaranAktif->ganjil_genap == 'Ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];
    
        $matkuls = Matakuliah::whereIn('smt', $semesterToDisplay)->get();
        return view('perkuliahan.create', compact('dosens', 'matkuls'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:255',
            'nidn' => 'required|exists:dosen,nidn',
            'kode' => 'required|exists:matakuliah,kode',
        ]);

        $activeTahunAjaran = TahunAjaran::getActiveTahunAjaran();
        if (!$activeTahunAjaran) {
            return redirect()->route('perkuliahan.index')->with('error', 'No active Tahun Ajaran found.');
        }
    
        $validated['tahun_ajaran_id'] = $activeTahunAjaran->id;
    
        Perkuliahan::create($validated);

        return redirect()->route('perkuliahan.index')->with('success', 'Perkuliahan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perkuliahan $perkuliahan)
    {
        return view('perkuliahan.show', compact('perkuliahan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perkuliahan = Perkuliahan::findOrFail($id);
        $dosens = Dosen::all();
        $matkuls = Matakuliah::all();
        
        return view('perkuliahan.edit', compact('perkuliahan', 'dosens', 'matkuls'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perkuliahan $perkuliahan)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:255',
            'nidn' => 'required|exists:dosen,nidn',
            'kode' => 'required|exists:matakuliah,kode',
        ]);

        $perkuliahan->update($validated);

        return redirect()->route('perkuliahan.index')->with('success', 'Perkuliahan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perkuliahan $perkuliahan)
    {
        $perkuliahan->delete();

        return redirect()->route('perkuliahan.index')->with('success', 'Perkuliahan deleted successfully.');
    }
}
