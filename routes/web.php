<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/crearEncuesta', [App\Http\Controllers\HomeController::class, 'crearEncuesta'])->name('crearEncuesta');
Route::post('/crearPregunta', [App\Http\Controllers\HomeController::class, 'crearPregunta'])->name('crearPregunta');
Route::post('/crearOpcion', [App\Http\Controllers\HomeController::class, 'crearOpcion'])->name('crearOpcion');
Route::get('/verEncuestas/{id_encuesta}', [App\Http\Controllers\HomeController::class, 'verEncuestas'])->name('verEncuestas');