<?php

use App\Livewire\Category\CategoryIndex;
use App\Livewire\Product\ProductIndex;
use App\Livewire\Request\RequestIndex;
use App\Livewire\Product\SingleProduct;
use App\Livewire\Request\SingleRequest;
use App\Livewire\User\UserIndex;
use App\Livewire\UserProfile;
use App\Models\Category;
use App\Models\Product;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        $requests = Request::all();

        return view('dashboard', [
            'user' => $user,
            'users' => $users,
            'products' => $products,
            'categories' => $categories,
            'requests' => $requests,
        ]);
    })->name('dashboard');

    // Users
    Route::get('/users', UserIndex::class)->name('users');

    // Single user
    Route::get('/users/{userId}', UserProfile::class)->name('user-profile');

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
