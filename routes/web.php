<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('index');

Route::post('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search-history', [SearchController::class, 'search_history'])->name('search_history');
