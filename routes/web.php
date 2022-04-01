<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::controller(SocioController::class)->group(function(){
    Route::get('socios', 'index')->name('socios.index');
    Route::get('socios/registrar', 'create')->name('socios.registrar');
    Route::get('socios/guardar', 'store')->name('socios.store');
    Route::get('socios/mostrar', 'show')->name('socios.show');
});

Route::get('/reportes', [ReporteController::class, 'index'])->name('reporte.index');
