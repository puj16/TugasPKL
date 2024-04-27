<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PesananDetailController;

Route::get('/', function () {
    return view ('welcome');
});


Route::get('home', [HalamanController::class, 'home']);
Route::get('home', [PesananDetailController::class, 'index']);
Route::get('export-csv', [PesananDetailController::class, 'exportCsv']);
