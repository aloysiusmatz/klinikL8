<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedrecController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\RunscriptController;
use App\Http\Controllers\HistoryController;


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

Route::middleware(['auth:sanctum', 'verified'])->get('/medrec', function () {
    return view('pages.medrec.index');
})->name('dashboard');


Route::get('/medrec/search', [MedrecController::class, 'search'])->middleware('auth')->name('medrec.search');
Route::get('/reportcheckupsearch', [CheckupController::class, 'search'])->middleware('auth')->name('report_checkup_search');
Route::get('/historycheckup', [HistoryController::class, 'search'])->middleware('auth');
Route::get('/printsickletter', [PrintController::class, 'printsickletter'])->middleware('auth');
Route::get('/openhealthletter/{id}', [PrintController::class, 'openhealthletter'])->middleware('auth')->name('print.healthletter');
Route::get('/opensickletter/{id}', [PrintController::class, 'opensickletter'])->middleware('auth');
Route::get('/runscript', [RunscriptController::class, 'index'])->middleware('auth');
Route::get('/usrsettings/{id}/updatepass', [UserSettingsController::class, 'updatePassword'])->middleware('auth')->name('usrsettings.updatepass');

Route::resource('medrec', MedrecController::class)->middleware('auth');
Route::resource('checkup', CheckupController::class)->middleware('auth');
Route::resource('gensettings', SettingsController::class)->middleware('auth');
Route::resource('usrsettings', UserSettingsController::class)->middleware('auth');

