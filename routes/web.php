<?php

use App\Http\Controllers\ImportExportSapiController;
use App\Http\Controllers\Sapi;
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
