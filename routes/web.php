<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelController;

Route::get('/', [TravelController::class, 'index'])->name('home');
Route::get('/search', [TravelController::class, 'search'])->name('travel.search');
Route::get('/agency/{id}', [TravelController::class, 'agencyDetails'])->name('agency.details');

