<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardKaprodiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\MonitoringKehadiranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerkuliahanController;
use App\Http\Controllers\SkalanilaiController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Pengguna.login');
});
Route::get('/master', function () {
    return view('master');
});

Route::get('/beranda', [BerandaController::class, 'index']);
Route::get('penilaian/index-per-dosen', [PenilaianController::class, 'indexPerDosen'])->name('penilaian.index-per-dosen');
Route::get('penilaian/indexadmin', [PenilaianController::class, 'indexAdmin'])->name('penilaian.indexadmin');
Route::post('tahunajaran/activate/{tahunajaran}', [TahunAjaranController::class, 'activateAgain'])->name('tahunajaran.activateAgain');

// Route::get('penilaian/admin', [PenilaianController::class, 'indexAdmin'])->name('penilaian.indexadmin');
Route::get('penilaian/krs', [PenilaianController::class, 'penilaianKRS'])->name('penilaian.krs');
Route::get('penilaian/admin/semester', [PenilaianController::class, 'indexAdminSemester'])->name('penilaian.indexadmin.semester');
Route::get('penilaian/admin/semester/{semester}', [PenilaianController::class, 'getCoursesByAdminSemester'])->name('penilaian.admin.courses.semester');
Route::get('penilaian/admin/semester/{semester}/hasil', [PenilaianController::class, 'hasilPenilaianPerSemester'])->name('penilaian.admin.hasil.semester');
// Route::get('/penilaian/hasil-semester/{semester}', [PenilaianController::class, 'hasilPenilaianPerSemester'])->name('penilaian.hasil-semester');
Route::get('penilaian/admin/semester/{semester}/hasil/tabel', [PenilaianController::class, 'hasilPenilaianPerSemesterTabel'])->name('penilaian.admin.hasil.semester.tabel');
Route::get('penilaian/admin/semester/{semester}/tabel-hasil', [PenilaianController::class, 'tabelHasilPenilaianPerSemester'])->name('penilaian.admin.tabel.hasil.semester');

Route::get('/monitoring_kehadiran/check_previous', [MonitoringKehadiranController::class, 'checkPrevious']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/penilaian/tahunajaran/{id}', [PenilaianController::class, 'lihatHasilTahunAjaran'])->name('penilaian.tahunajaran');

    Route::get('/krs', [KrsController::class, 'index']);
    Route::get('/krs/create', [KrsController::class, 'create']);
    Route::post('/krs/store', [KrsController::class, 'store']);
    Route::post('/krs/validate/{id}', [KrsController::class, 'validateKrs'])->name('krs.validate');

    Route::resource('penilaian', PenilaianController::class);
    Route::get('penilaian/{id}/beri-nilai', [PenilaianController::class, 'beriNilai'])->name('penilaian.beri-nilai');
    // Route::get('penilaian/semester/{semester}', [PenilaianController::class, 'getCoursesBySemester'])->name('penilaian.get-courses');

    //Route::get('penilaian/show/{id}', [PenilaianController::class, 'show'])->name('penilaian.show');
    
  


    Route::resource('tahunajaran', TahunAjaranController::class);
    Route::resource('perkuliahan', PerkuliahanController::class);
    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::get('evaluasi/{id}/beri-nilai', [EvaluasiController::class, 'beriNilai'])->name('evaluasi.beri-nilai');
    Route::post('/evaluasi/store', [EvaluasiController::class, 'store'])->name('evaluasi.store');

    Route::post('/periode-penilaian-selesai', [TahunAjaranController::class, 'periodePenilaianSelesai'])->name('periode-penilaian-selesai');
    Route::resource('monitoring_kehadiran', MonitoringKehadiranController::class)->except(['show']);

    Route::get('monitoring_kehadiran/rekapitulasi', [MonitoringKehadiranController::class, 'rekapitulasi'])->name('monitoring_kehadiran.rekapitulasi');

Route::get('/hasil-evaluasi-kehadiran', [EvaluasiController::class, 'hasilEvaluasiKehadiran'])->name('hasil-evaluasi-kehadiran');
Route::get('/hasil-evaluasi-kehadiran/{id}', [EvaluasiController::class, 'detailEvaluasi'])->name('detail-evaluasi');
Route::get('/hasil-rekapitulasi-kehadiran', [MonitoringKehadiranController::class, 'hasilRekapitulasi'])->name('hasil-rekapitulasi-kehadiran');
Route::get('monitoring-kehadiran/cetak-rekapitulasi', [MonitoringKehadiranController::class, 'cetakRekapitulasi'])->name('hasil-rekapitulasi-kehadiran.cetak');

});
Route::get('/dashboard-kaprodi/laporan-cetak', [DashboardKaprodiController::class, 'cetakLaporan'])->name('laporan-cetak');

Route::get('/dosen-terbaik', [DashboardKaprodiController::class, 'dosenTerbaik'])->name('dosen-terbaik');
Route::get('/dashboard-kaprodi/hasil-pemeringkatan', [DashboardKaprodiController::class, 'hasilPemeringkatan'])->name('hasil-pemeringkatan');
Route::post('/dashboard-kaprodi/validasi-rank', [DashboardKaprodiController::class, 'validasiRank'])->name('validasi-rank');

Route::get('/dashboard-kaprodi', [DashboardKaprodiController::class, 'index'])->name('dashboard-kaprodi')->middleware('auth');
Route::get('/kriteria', [KriteriaController::class, 'index']);
Route::get('/kriteria/create', [KriteriaController::class, 'create']);
Route::post('/kriteria/store', [KriteriaController::class, 'store']);
Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit']);
Route::put('/kriteria/{id}', [KriteriaController::class, 'update']);
Route::get('/get-perkuliahan', [NilaiController::class, 'getPerkuliahan'])->name('get-perkuliahan');
Route::get('/nilai', [NilaiController::class, 'index']);
Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
Route::get('/nilai/{id}/show', [NilaiController::class, 'show']);
Route::get('/nilai/{id}/proses', [NilaiController::class, 'proses']);
Route::get('/nilai-print', [NilaiController::class, 'print']);
Route::get('/laporan', [NilaiController::class, 'laporan']);
Route::post('/nilai/store', [NilaiController::class, 'store']);
Route::post('/nilai/store2', [NilaiController::class, 'store2']);
Route::get('/nilai/{id}/edit', [NilaiController::class, 'edit']);
Route::put('/nilai/{id}', [NilaiController::class, 'update']);

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create']);
Route::get('/mahasiswa/create2', [MahasiswaController::class, 'create2']);
Route::post('/mahasiswa/store', [MahasiswaController::class, 'store']);
Route::post('/mahasiswa/store2', [MahasiswaController::class, 'store2']);
Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit']);
Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::delete('/mahasiswa/delete/{id}', [MahasiswaController::class, 'delete'])->name('delete');

Route::get('/dosen/', [DosenController::class, 'index']);
Route::get('/dosen/create', [DosenController::class, 'create']);
Route::post('/dosen/store', [DosenController::class, 'store']);
Route::get('/dosen/{id}/edit', [DosenController::class, 'edit']);
Route::put('/dosen/{id}', [DosenController::class, 'update']);
Route::delete('/dosen/{id}', [DosenController::class, 'destroy']);

Route::get('/skalanilai/index', [SkalanilaiController::class, 'index']);
Route::get('/skalanilai', [SkalanilaiController::class, 'index']);

// Route::get('/matkul',[MatkulController::class,'index']);
Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/create', [MatakuliahController::class, 'create']);
Route::post('/matakuliah/store', [MatakuliahController::class, 'store']);
Route::get('/matakuliah/{id}/edit/', [MatakuliahController::class, 'edit']);
Route::put('/matakuliah/update/{id}', [MatakuliahController::class, 'update']);
Route::delete('/matakuliah/delete/{id}', [MatakuliahController::class, 'destroy']);

Route::get('/saw', [SawController::class, 'index']);

Route::get('/login', function () {
    return view('Pengguna.login');
})->name('login');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
