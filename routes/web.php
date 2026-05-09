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

// Auth Routes
// Changed signup route name for clarity when linking from other pages
Route::get('/signup', function () {
    return view('auth.signup');
})->name('auth.signup'); // Renamed from signup.submit if it was used for the GET route

Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // This is the primary login route name

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// ==========================
// PRODUCTS ROUTES
// ==========================
Route::resource('products', ProductController::class);


// ==========================
// CATEGORIES ROUTES
// ==========================
// Replace the individual routes below with this single line:
Route::resource('categories', CategoriesController::class);

// Removed old individual category routes:
// Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
// Route::get('/categories/create', function () {
//     return view('categories.create');
// })->name('categories.create');
// Route::get('/categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');
// Route::get('/categories/{id}/edit', [CategoriesController::class, 'edit')->name('categories.edit');
// Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');


// ==========================
// INVENTORY ROUTES
// ==========================
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{product}', [InventoryController::class, 'update'])->name('inventory.update');

// ==========================
// PRICES ROUTES
// ==========================
Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
Route::get('/prices/{product}/edit', [PriceController::class, 'edit'])->name('prices.edit');
// Add the POST route for updating the price, using {product} for route model binding
Route::post('/prices/{product}', [PriceController::class, 'update'])->name('prices.update');

// ==========================
// SUPER ADMIN ROUTES
// ==========================
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