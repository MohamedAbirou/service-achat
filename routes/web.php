<?php

use App\Livewire\Category\CategoryIndex;
use App\Livewire\ProductIndex;
use App\Livewire\RequestIndex;
use App\Livewire\SingleProduct;
use App\Livewire\SingleRequest;
use App\Livewire\User\UserIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

    // Users
    Route::get('/users', UserIndex::class)->name('users');

    // Products
    Route::get('/products', ProductIndex::class)->name('products');

    // Single product
    Route::get('/products/{productId}', SingleProduct::class)->name('single-product');

    // Categories
    Route::get('/categories', CategoryIndex::class)->name('categories');

    // Requests
    Route::get('/requests', RequestIndex::class)->name('requests');

    // Single request
    Route::get('/requests/{requestId}', SingleRequest::class)->name('single-request');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
