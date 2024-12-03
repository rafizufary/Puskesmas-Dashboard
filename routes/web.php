<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RawatjalanController;
use App\Http\Controllers\RawatjalanDetailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/checklogin', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware'=>['auth','CheckLevel:super_admin,admin']], function(){
    //menampilakan halaman user
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/detailuser', [UsersController::class, 'detailuser'])->name('detailUser');
    Route::post('/user/{id}/update', [UsersController::class, 'update'])->name('user.update');
    Route::get('/user/{id}/destroy', [UsersController::class, 'destroy'])->name('user.destroy');
});

Route::group(['middleware'=>['auth','CheckLevel:super_admin']], function(){
    //menampilakan halaman user
    Route::get('/user', [UsersController::class, 'index'])->name('user');
    Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');
    // Route::post('/user/{id}/update', [UsersController::class, 'update']);
    // Route::get('/user/{id}/destroy', [UsersController::class, 'destroy']);
    // Route::get('/detailuser', [UsersController::class, 'detailuser']);
    Route::get('/user/exportUser', [UsersController::class, 'exportUser'])->name('exportUser');

    Route::get('/poli', [PoliController::class, 'index'])->name('poli');
    Route::post('/poli/store', [PoliController::class, 'store'])->name('poli.store');
    Route::post('/poli/{id}/update', [PoliController::class, 'update'])->name('poli.update');
    Route::get('/poli/{id}/destroy', [PoliController::class, 'destroy'])->name('poli.destroy');
    Route::get('/poli/exportPoli', [PoliController::class, 'exportPoli'])->name('exportPoli');
    
});

//melakukan pengecekan untuk route 
Route::group(['middleware'=>['auth','CheckLevel:admin,super_admin']], function(){
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien');
    Route::post('/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/edit/{id}', [PasienController::class, 'edit'])->name('editPasien');
    Route::get('/pasien/form',[PasienController::class,'form'])->name('form');
    Route::post('/pasien/getkabupaten',[PasienController::class,'getkabupaten'])->name('getkabupaten');
    Route::post('/pasien/getkecamatan',[PasienController::class,'getkecamatan'])->name('getkecamatan');
    Route::post('/pasien/getkelurahan',[PasienController::class,'getkelurahan'])->name('getkelurahan');
    Route::post('/pasien/{id}/update', [PasienController::class, 'update'])->name('pasien.update');
    Route::get('/pasien/{id}/destroy', [PasienController::class, 'destroy'])->name('pasien.destroy');
    Route::get('/pasien/export', [PasienController::class, 'exportPasien'])->name('exportPasien');


    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa');
    Route::post('/diagnosa/store', [DiagnosaController::class, 'store'])->name('diagnosa.store');
    Route::post('/diagnosa/{id}/update', [DiagnosaController::class, 'update'])->name('diagnosa.update');
    Route::get('/diagnosa/{id}/destroy', [DiagnosaController::class, 'destroy'])->name('diagnosa.destroy');
    Route::get('/diagnosa/export', [DiagnosaController::class, 'exportDiagnosa'])->name('exportDiagnosa');

    Route::post('/pemetaan/penyakit', [App\Http\Controllers\WebController::class, 'pemetaanPenyakit'])->name('pemetaanPenyakit');
    Route::get('/pemetaan/penyakit/detail/{id}/{penyakitSel}', [App\Http\Controllers\WebController::class, 'pemetaanPenyakitDetail']);

    Route::get('/petugas', [PetugasController::class, 'index']);
    Route::post('/petugas/store', [PetugasController::class, 'store']);
    Route::post('/petugas/{id}/update', [PetugasController::class, 'update']);
    Route::get('/petugas/{id}/destroy', [PetugasController::class, 'destroy']);

    Route::get('rawatjalan', [RawatjalanController::class, 'index'])->name('rawatjalan');
    Route::get('historyrawatjalan', [RawatjalanController::class, 'history'])->name('history');
    Route::get('historyrawatjalan/rawatjalanhistorydetail/{id_pasien}/{id_diagnosa}', [RawatjalanController::class, 'detailHistory']);
    Route::get('historyrawatjalan/export/{id_pasien}/{id_diagnosa}', [RawatjalanController::class, 'exportDetail'])->name('detailExport');

    Route::get('pemetaan/export/{id}', [App\Http\Controllers\WebController::class, 'exportDataPemetaan'])->name('exportDataPemetaan');

    Route::get('selectPasien',[RawatjalanController::class,'datapasien'])->name('datapasien.index');

    Route::post('rawatjalan/store', [RawatjalanController::class, 'store']);
    Route::patch('rawatjalan/update/{id}', [RawatjalanController::class, 'update'])->name('rawatjalan1');
    Route::delete('rawatjalan/destroy/{id}', [RawatjalanController::class, 'destroy'])->name('rawatjalan2');
    Route::get('rawatjalan/detail/{id}', [RawatjalanDetailController::class, 'index'])->name('rawatjalan.detail');
    Route::post('/rawatjalan/{id}/update', [RawatjalanDetailController::class, 'update'])->name('rawatjalan.update');
    Route::get('/rawatjalan/{id}/destroy', [RawatjalanDetailController::class, 'destroy'])->name('rawatjalan.destroy');
    Route::get('/rawatjalan/{id}/selesai', [RawatjalanDetailController::class, 'selesai'])->name('rawatjalan.selesai');


    Route::get('/pemetaan',[App\Http\Controllers\WebController::class, 'index'])->name('pemetaan.index');
    Route::get('/pemetaan/detail/{id}', [App\Http\Controllers\WebController::class, 'pemetaan'])->name('pemetaan');
    Route::get('/kirimpesan/{pasienId}/{tglControl}/{poli}/{diagnosaId}', [HomeController::class, 'kirimPesan'])->name('kirimpesan');

    Route::get('/pemetaan/exportPemetaan',[App\Http\Controllers\WebController::class, 'exportPemetaan'])->name('exportPemetaan');

    Route::get('/verifikasi',[App\Http\Controllers\VerifikasiController::class, 'index']);
    Route::get('/verifikasi/{id}',[App\Http\Controllers\VerifikasiController::class, 'store'])->name('verifikasi');

    Route::get('/check-nik/{nik}', [PasienController::class,'checkNIK'])->name('check.nik');

});

Route::get('indonesia', function () { return view('formindonesia');});

Route::get('selectPasien',[RawatjalanController::class,'datapasien'])->name('datapasien.index');
Route::get('tesRelasi',[PasienController::class,'tes'])->name('tesRelasi');
Route::post('tesRelasi-store',[PasienController::class,'tesStore'])->name('tesRelasi-store');

