<?php

use App\Http\Controllers\AlgoritmaController;
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


    // sapi testing
    Route::resource('sapi-testing', SapiTestingController::class);
    Route::get('/sapi-testing/{id}/delete', [SapiTestingController::class, 'destroy']);
    Route::post('/sapi-testing-import', [SapiTestingController::class, 'ImportDataTesting'])->name('sapi.import.testing');
    Route::get('/sapi--testing-export', [SapiTestingController::class, 'ExportExcelTesting'])->name('sapi.excel.testing');
    Route::get('/sapi--testing-exportcsv', [SapiTestingController::class, 'ExportCSVTesting'])->name('sapi.csv.testing');
    Route::get('/sapi-testing-import-form', [SapiTestingController::class, 'formInputTesting'])->name('sapi.importForm.testing');

    // algoritma

    Route::get('/fuzzy-c-means', [AlgoritmaController::class, 'fcm'])->name('fuzzy-c-means');
    Route::post('/fuzzy-c-means', [AlgoritmaController::class, 'processFCM'])->name('fuzzy-c-means.process');



    Route::get('/fuzzy-tahani', [AlgoritmaController::class, 'ftahani'])->name('fuzzy-tahani');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');