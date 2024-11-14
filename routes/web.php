<?php

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
