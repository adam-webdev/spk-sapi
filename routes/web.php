<?php

use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\FuzzyTahaniController;
use App\Http\Controllers\ImportExportSapiController;
use App\Http\Controllers\Sapi;
use App\Http\Controllers\SapiTestingController;
use App\Models\SapiTesting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('layouts.layoutmaster');
    })->name('dashboard');

    Route::resource('sapi', Sapi::class);
    Route::get('/sapi/{id}/delete', [Sapi::class, 'destroy']);
    Route::post('/sapi-import', [Sapi::class, 'ImportData'])->name('sapi.import');
    Route::get('/sapi-export', [Sapi::class, 'ExportExcel'])->name('sapi.excel');
    Route::get('/sapi-exportcsv', [Sapi::class, 'ExportCSV'])->name('sapi.csv');
    Route::get('/sapi-import-form', [Sapi::class, 'formInput'])->name('sapi.importForm');
    Route::get('/load-sapi', [Sapi::class, 'normalisasiDataSapi']);
    Route::get('/dataset-sapi', [Sapi::class, 'datasetSapi'])->name('dataset-sapi');


    // algoritma FCM

    Route::get('/fcm-data', [FCMController::class, 'index'])->name('fcm.data');

    Route::get('/fuzzy-c-means', [FCMController::class, 'fcm'])->name('fuzzy-c-means');
    Route::post('/fuzzy-c-means', [FCMController::class, 'prosesFCM'])->name('fuzzy-c-means.process');

    Route::get('/fuzzy-c-means/{id}', [FCMController::class, 'detail'])->name('fcm.detail');

    Route::get('/fuzzy-c-means/{id}/{format}', [FCMController::class, 'exportHasilFcm'])->name('fcm.export');


    Route::get('/generate-matrix', [AlgoritmaController::class, 'genereateMatriksU']);


    // algoritma fuzzy tahani
    Route::get('/fuzzy-tahani', [FuzzyTahaniController::class, 'index'])->name('fuzzy-tahani');

    Route::get('/fuzzy-tahani/q', [FuzzyTahaniController::class, 'create'])->name('fuzzy-tahani.create');

    Route::post('/fuzzy-tahani/q', [FuzzyTahaniController::class, 'store'])->name('ftahani.process');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
