<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function index()
    {
     $dosen = Dosen::all();
     return view('dosen.index',compact(['dosen']));
        // $dosen = DB::table('dosen')
        // ->selectRaw("*, matakuliah.nama as nama_mk")
        // ->selectRaw("dosen.nama as nama_dosen")
        // ->selectRaw("dosen.id as id_dosen")
        // ->get();
        // return view('dosen.index')->with('dosen', $dosen);
    }

    public function create()
    {
        $matakuliah = Matakuliah::all();
        return view('dosen.create')->with('matakuliah', $matakuliah);
    }

    public function store(Request $request)
    {
        Dosen::create($request->except(['_token','submit']));
        return redirect('/dosen');
    }

    public function edit($id)
    {
        $dosen = Dosen::where('nidn', $id)->first();
        $matakuliah = Matakuliah::all();
        return view('dosen.edit',compact(['dosen', 'matakuliah']));
    }

    public function update($id, Request $request)
    {
        $dosen = Dosen::where('nidn', $id)->first();
        $dosen->update($request->except(['_token','submit']));
        return redirect('/dosen')->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $dosen = Dosen::where('nidn', $id)->first();
        $dosen->delete();
        return redirect(('/dosen'));
    }
}