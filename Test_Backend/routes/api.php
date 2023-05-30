<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('pegawai', [PegawaiController::class, 'index']);
    Route::post('pegawai', [PegawaiController::class, 'store']);
    Route::get('pegawai/{id}', [PegawaiController::class, 'show']);
    Route::put('pegawai/{id}', [PegawaiController::class, 'update']);
    Route::delete('pegawai/{id}', [PegawaiController::class, 'destroy']);
    Route::get('user', [UserController::class, 'getUserByToken']);
    Route::post('getToken', [UserController::class, 'getTokenByUser']);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

