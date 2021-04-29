<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedrecController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\PrintController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('pages.medrec.index');
})->name('dashboard');


Route::get('/medrec/search', [MedrecController::class, 'search'])->name('medrec.search');
Route::get('/reportcheckupsearch', [CheckupController::class, 'search'])->name('report_checkup_search');
Route::get('/printsickletter', [PrintController::class, 'printsickletter']);
Route::get('/openhealthletter/{id}', [PrintController::class, 'openhealthletter'])->name('print.healthletter');
Route::get('/opensickletter/{id}', [PrintController::class, 'opensickletter']);

Route::resource('medrec', MedrecController::class);
Route::resource('checkup', CheckupController::class);

