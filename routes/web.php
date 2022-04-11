<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/index/{token}', [HomeController::class, 'index']);
Route::get('/citas/{token}', [HomeController::class, 'citas']);
Route::post('/buscarMedicos', [HomeController::class, 'buscarMedicos']);
Route::post('/buscarTurnos', [HomeController::class, 'buscarTurnos']);
Route::post('/asignarTurno', [HomeController::class, 'asignarTurno']);

