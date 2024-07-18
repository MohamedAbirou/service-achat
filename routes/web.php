<?php

use App\Http\Controllers\CategoryIndex;
use App\Livewire\ProductIndex;
use App\Livewire\UserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/users', UserIndex::class);
Route::get('/products', ProductIndex::class);
Route::get('/categories', [CategoryIndex::class, 'index']);
