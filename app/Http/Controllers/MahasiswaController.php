<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use App\Models\User;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('nim', 'ASC')->get();
        return view('mahasiswa.index',compact(['mahasiswa']));;
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function create2()
    {
        return view('mahasiswa.create2');
    }

    public function store(Request $request)
    {
        Mahasiswa::create($request->except(['_token','submit']));

        User::create([
            'name' => $request->nama,
            'level' => 'Mahasiswa',
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);

        return redirect('/mahasiswa');
    }

    public function store2(Request $request)
    {
        Mahasiswa::create($request->except(['_token','submit']));

        User::create([
            'name' => $request->nama,
            'level' => 'Mahasiswa',
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);

        return redirect('/login');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit',compact(['mahasiswa']));
    }

    public function update($id, Request $request)
    {
        $mahasiswa = Mahasiswa::where('nim', $id)->first();
        $mahasiswa->update($request->except(['_token','submit']));
        return redirect('/mahasiswa');
    }

    public function delete($id)
    {
        $data = Mahasiswa::where('nim', $id)->first();
        $data->delete();
        return redirect('/mahasiswa');
    }

}