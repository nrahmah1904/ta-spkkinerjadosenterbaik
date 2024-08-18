<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif yang sesuai.');
        }

        $semesterToDisplay = $tahunAjaranAktif->ganjil_genap == 'Ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];

        $matakuliah = Matakuliah::whereIn('smt', $semesterToDisplay)
            ->get();

        return view('matakuliah.index', compact('matakuliah'));
    }


    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        Matakuliah::create($request->except(['_token', 'submit']));
        return redirect('/matakuliah');
    }

    public function edit($id)
    {
        $matakuliah = Matakuliah::where('kode', $id)->first();
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, $id)
    {
        $matakuliah = Matakuliah::where('kode', $id)->first();
        $matakuliah->update($request->except(['_token', '_method']));
        return redirect('/matakuliah')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $matakuliah = Matakuliah::where('kode', $id)->first();
        $matakuliah->delete();
        return redirect('/matakuliah')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}
