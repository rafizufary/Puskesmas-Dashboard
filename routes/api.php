<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasienController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('pasien', [PasienController::class, 'index']);
Route::get('pasien/{id}', [PasienController::class, 'show']);
Route::post('pasien', [PasienController::class, 'store']);
Route::delete('pasien/{id}', [PasienController::class, 'destroy']);
