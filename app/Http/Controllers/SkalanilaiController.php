<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Skalanilai;
use Illuminate\Http\Request;

class SkalanilaiController extends Controller
{
    public function index()
    {
        $skalanilai = Skalanilai::all();
       // $skalanilai = Skalanilai::with('kriteria')->paginate();
        return view('skalanilai.index',compact(['skalanilai']));
    }
}