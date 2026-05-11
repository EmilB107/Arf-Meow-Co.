<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjManController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

// ==========================
// AUTH ROUTES
// ==========================
Route::get('/signup', function () {
    return view('auth.signup');
})->name('auth.signup');

Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================
// PROTECTED ROUTES
// ==========================
Route::middleware('auth')->group(function () {

    // DASHBOARD — Admin + Project Manager only
    Route::middleware('role:Admin,Project Manager')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // PRODUCTS
        // Static segments (create) must come before wildcards ({product}) to avoid capture
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('role:Admin');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('role:Admin');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('role:Admin');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('role:Admin');
        Route::patch('/products/{product}', [ProductController::class, 'update'])->middleware('role:Admin');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('role:Admin');

        // CATEGORIES — Admin only
        Route::resource('categories', CategoriesController::class)
            ->middleware('role:Admin');

        // INVENTORY
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{product}', [InventoryController::class, 'update'])->name('inventory.update');

        // PRICES
        Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
        Route::get('/prices/{product}/edit', [PriceController::class, 'edit'])->name('prices.edit');
        Route::post('/prices/{product}', [PriceController::class, 'update'])->name('prices.update');

    });

    // SUPER ADMIN — Super Admin only
    Route::middleware('role:Super Admin')->group(function () {

        Route::get('/superadmin', function () {
            return view('superadmin.index');
        })->name('superadmin.index');

        Route::prefix('superadmin')->group(function () {

            // USERS
            Route::get('/user', [UsersController::class, 'index'])->name('user.index');
            Route::get('/user/create', [UsersController::class, 'create'])->name('user.create');
            Route::get('/user/{id}', [UsersController::class, 'show'])->name('user.show');
            Route::get('/user/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
            Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');

            // ADMINS
            Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
            Route::get('/admin/{id}', [AdminController::class, 'show'])->name('admin.show');
            Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

            // PROJECT MANAGERS
            Route::get('/project-manager', [ProjManController::class, 'index'])->name('project-manager.index');
            Route::get('/project-manager/create', [ProjManController::class, 'create'])->name('project-manager.create');
            Route::get('/project-manager/{id}', [ProjManController::class, 'show'])->name('project-manager.show');
            Route::get('/project-manager/{id}/edit', [ProjManController::class, 'edit'])->name('project-manager.edit');
            Route::delete('/project-manager/{id}', [ProjManController::class, 'destroy'])->name('project-manager.destroy');
        });

    });

});
