<?php

use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ValidIDController;
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

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/barangays', [BarangayController::class, 'index'])->name('barangays.index');
    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/diseases', [DiseaseController::class, 'index'])->name('diseases.index');
    Route::get('/scanners', [ScannerController::class, 'index'])->name('scanners.index');
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
    Route::get('/valid-ids', [ValidIDController::class, 'index'])->name('valid-ids.index');
    Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
});
