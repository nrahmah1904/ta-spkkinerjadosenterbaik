<?php
namespace App\Http\Controllers;

use App\Models\Evaluasimhs;
use App\Models\Evaluasiupm;
use App\Models\EvaluasiUpmDetail;
use App\Models\Kriteria;
use App\Models\Perkuliahan;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class EvaluasiController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaranAktif) {
            return redirect()->to('beranda')->with('error', 'Tidak ada tahun ajaran aktif yang sesuai.');
        }

        $perkuliahans = Perkuliahan::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get();

        $kriteria = Kriteria::all();

        return view('evaluasi.index', compact('perkuliahans'));
    }
    
    public function beriNilai($id)
    {
        $perkuliahan = Perkuliahan::findOrFail($id);
    
        $criteria1_3 = Kriteria::whereIn('kode', ['C22', 'C23', 'C24', 'C25'])->get();
        $criteria4_6 = Kriteria::whereIn('kode', ['C22', 'C23', 'C24', 'C25'])->get();
        $criteria7_9 = Kriteria::whereIn('kode', ['C22', 'C23', 'C24', 'C25'])->get();
        $criteria10_12 = Kriteria::whereIn('kode', ['C22', 'C23', 'C24', 'C25'])->get();
        $criteria13_15 = Kriteria::whereIn('kode', ['C22', 'C23', 'C24', 'C25'])->get();
    
        $existingEvaluations = EvaluasiupmDetail::whereHas('evaluasi', function($query) use ($id) {
            $query->where('perkuliahan_id', $id);
        })->get()->groupBy('kategori')->map(function ($group) {
            return $group->keyBy('kriteria_id');
        });
    
        return view('evaluasi.beri-nilai', compact('perkuliahan', 'criteria1_3', 'criteria4_6', 'criteria7_9', 'criteria10_12', 'criteria13_15', 'existingEvaluations'));
    }
    

    public function store(Request $request)
    {
        $activeTahunAjaran = TahunAjaran::getActiveTahunAjaran();
        if (!$activeTahunAjaran) {
            return redirect()->to('beranda')->with('error', 'No active Tahun Ajaran found.');
        }

        $tahun_ajaran_id = $activeTahunAjaran->id;

        DB::transaction(function () use ($request, $tahun_ajaran_id) {
            $evaluasiupm = Evaluasiupm::updateOrCreate(
                [
                    'perkuliahan_id' => $request->perkuliahan_id,
                    'tahun_ajaran_id' => $tahun_ajaran_id,
                ],
                [
                    'tanggal_penilaian' => Carbon::now(),
                ]
            );

            foreach ($request->id_kriteria as $index => $kriteriaId) {
                EvaluasiUpmDetail::updateOrCreate(
                    [
                        'evaluasi_id' => $evaluasiupm->id,
                        'kriteria_id' => $kriteriaId,
                        'kategori' => $request->kategori,
                    ],
                    [
                        'jawaban' => $request->jawaban[$index],
                        'created_at' => Carbon::now(),
                    ]
                );
            }
        });

        return redirect()->route('evaluasi.index')->with('success', 'Terimakasih Sudah Melakukan Penilaian Kepada Dosen');
    }

    public function hasilEvaluasiKehadiran()
    {

        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaranAktif) {
            return redirect()->to('beranda')->with('error', 'Tidak ada tahun ajaran aktif yang sesuai.');
        }

        $evaluasiupm = Evaluasiupm::with(['perkuliahan.dosen', 'perkuliahan.matkul', 'perkuliahan.tahunAjaran'])->where('evaluasiupm.tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();

        return view('evaluasi.hasil-kehadiran', compact('evaluasiupm'));
    }
    public function detailEvaluasi($id)
    {
        $perkuliahan = Perkuliahan::findOrFail($id);
    
        $criteriaGroups = [
            '1_3' => $this->getCriteriaDetails($id, '1_3'),
            '4_6' => $this->getCriteriaDetails($id, '4_6'),
            '7_9' => $this->getCriteriaDetails($id, '7_9'),
            '10_12' => $this->getCriteriaDetails($id, '10_12'),
            '13_15' => $this->getCriteriaDetails($id, '13_15'),
        ];
    
        // Filter out groups that have only null answers
        $criteriaGroups = array_filter($criteriaGroups, function($criteria) {
            return $criteria->contains(function($item) {
                return $item->jawaban !== null;
            });
        });
    
        return view('evaluasi.detail-kehadiran', compact('perkuliahan', 'criteriaGroups'));
    }
    
    private function getCriteriaDetails($perkuliahanId, $kategori)
    {
        return DB::table('kriteria')
            ->leftJoin('evaluasiupm_detail', function ($join) use ($perkuliahanId, $kategori) {
                $join->on('kriteria.id', '=', 'evaluasiupm_detail.kriteria_id')
                     ->where('evaluasiupm_detail.evaluasi_id', function ($query) use ($perkuliahanId) {
                         $query->select('id')
                               ->from('evaluasiupm')
                               ->where('perkuliahan_id', $perkuliahanId);
                     })
                     ->where('evaluasiupm_detail.kategori', $kategori);
            })
            ->whereIn('kriteria.kode', ['C22', 'C23', 'C24', 'C25'])
            ->select('kriteria.id', 'kriteria.kriteria', 'evaluasiupm_detail.jawaban')
            ->get();
    }
    

    
    
    
}

