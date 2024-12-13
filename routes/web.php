<?php

use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\FuzzyTahaniController;
use App\Http\Controllers\ImportExportSapiController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\Sapi;
use App\Http\Controllers\SapiTestingController;
use App\Models\SapiTesting;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/', function () {
    return view('layouts.home');
})->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        $totalSapi = \App\Models\Sapi::count();
        return view('dashboard', compact('totalSapi'));
    })->name('dashboard');

    Route::resource('sapi', Sapi::class);
    Route::get('/sapi/{id}/delete', [Sapi::class, 'destroy']);
    Route::post('/sapi-import', [Sapi::class, 'ImportData'])->name('sapi.import');
    Route::get('/sapi-export', [Sapi::class, 'ExportExcel'])->name('sapi.excel');
    Route::get('/sapi-exportcsv', [Sapi::class, 'ExportCSV'])->name('sapi.csv');
    Route::get('/sapi-import-form', [Sapi::class, 'formInput'])->name('sapi.importForm');
    Route::get('/load-sapi', [Sapi::class, 'normalisasiDataSapi'])->name('datasetsapi.load');
    Route::get('/dataset-sapi', [Sapi::class, 'datasetSapi'])->name('dataset-sapi');


    // algoritma FCM

    Route::get('/fcm-data', [FCMController::class, 'index'])->name('fcm.data');

    Route::get('/fuzzy-c-means', [FCMController::class, 'fcm'])->name('fuzzy-c-means');
    Route::post('/fuzzy-c-means', [FCMController::class, 'prosesFCM'])->name('fuzzy-c-means.process');

    Route::get('/fuzzy-c-means/{id}', [FCMController::class, 'detail'])->name('fcm.detail');

    Route::get('/fuzzy-c-means/{id}/{format}', [FCMController::class, 'exportHasilFcm'])->name('fcm.export');



    // algoritma fuzzy tahani
    Route::get('/fuzzy-tahani', [FuzzyTahaniController::class, 'index'])->name('fuzzy-tahani');

    Route::get('/fuzzy-tahani/q', [FuzzyTahaniController::class, 'create'])->name('fuzzy-tahani.create');

    Route::post('/fuzzy-tahani/q', [FuzzyTahaniController::class, 'store'])->name('ftahani.process');
    // Matriks 2-5

    Route::get('/matrix-2x2', [MatrixController::class, 'getMatrix2x2'])->name('datamatrix.2x2');
    Route::get('/matrix-2x2/generate', [MatrixController::class, 'generateMatrix2'])->name('generatematrix2x2');

    Route::get('/matrix-3x3', [MatrixController::class, 'getMatrix3x3'])->name('datamatrix.3x3');
    Route::get('/matrix-3x3/generate', [MatrixController::class, 'generateMatrix3'])->name('generatematrix3x3');

    Route::get('/matrix-4x4', [MatrixController::class, 'getMatrix4x4'])->name('datamatrix.4x4');
    Route::get('/matrix-4x4/generate', [MatrixController::class, 'generateMatrix4'])->name('generatematrix4x4');

    Route::get('/matrix-5x5', [MatrixController::class, 'getMatrix5x5'])->name('datamatrix.5x5');
    Route::get('/matrix-5x5/generate', [MatrixController::class, 'generateMatrix5'])->name('generatematrix5x5');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');