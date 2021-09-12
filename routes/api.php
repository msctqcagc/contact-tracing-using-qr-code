<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarangayController;
use App\Http\Controllers\API\DiseaseController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\ResidentController;
use App\Http\Controllers\API\ResidentDocumentController;
use App\Http\Controllers\API\ScannedResidentController;
use App\Http\Controllers\API\ScannerController;
use App\Http\Controllers\API\ValidIDController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('test', function() {
        return json_encode(['data' => 'Authenticated']);
    });
});

// Barangays
Route::get('barangays', [BarangayController::class, 'index']);
Route::post('barangays', [BarangayController::class, 'store']);
Route::put('barangays/{id}', [BarangayController::class, 'update']);
Route::delete('barangays/{id}', [BarangayController::class, 'destroy']);

// Diseases
Route::get('diseases', [DiseaseController::class, 'index']);
Route::post('diseases', [DiseaseController::class, 'store']);
Route::put('diseases/{id}', [DiseaseController::class, 'update']);
Route::delete('diseases/{id}', [DiseaseController::class, 'destroy']);

// Scanners
Route::get('scanners', [ScannerController::class, 'index']);
Route::post('scanners', [ScannerController::class, 'store']);
Route::put('scanners/{id}', [ScannerController::class, 'update']);
Route::delete('scanners/{id}', [ScannerController::class, 'destroy']);

// Requests
Route::resource('requests', RequestController::class);

// Residents
Route::get('residents/{id}/requests/decline', [ResidentController::class, 'decline']);
Route::get('residents/{id}/requests/approve', [ResidentController::class, 'approve']);
Route::resource('residents', ResidentController::class);

// Valid IDs
Route::get('valid-ids/active', [ValidIDController::class, 'active']);
Route::resource('valid-ids', ValidIDController::class);

// Documents
Route::post('residents/{id}/documents', [ResidentDocumentController::class, 'upload']);

// Scanned Residents
Route::resource('scanned-residents', ScannedResidentController::class);
