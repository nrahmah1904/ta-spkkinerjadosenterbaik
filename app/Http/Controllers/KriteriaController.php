<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('id', 'ASC')->get();
        return view('kriteria.index',compact(['kriteria']));;
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        Kriteria::create($request->except(['_token','submit']));
        return redirect('/kriteria');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::find($id);
        return view('kriteria.edit',compact(['kriteria']));
    }

    public function update($id, Request $request)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->update($request->except(['_token','submit']));
        return redirect('/kriteria');
    }

}