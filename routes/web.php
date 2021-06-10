<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchMenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenuitemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/aboutus', [FrontController::class, 'aboutus'])->name('aboutus');
Route::get('/shop', [FrontController::class, 'shop'])->name('shop');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 Route::group(['middleware' => ['auth']], function() {
    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('category', CategoryController::class);


    Route::resource('branch', BranchController::class);
    Route::get('/branchmenu/{id}', [BranchMenuController::class, 'index'])->name('branchmenu.index');
    Route::get('/branchmenu/create/{id}', [BranchMenuController::class, 'create'])->name('branchmenu.create');
    Route::resource('branchmenu', BranchMenuController::class, ['except' => ['index', 'create']]);

    Route::resource('driver', DriverController::class);
    Route::resource('menuitem', MenuitemController::class);

    Route::resource('setting', SettingController::class);

    // Route::resource('product', ProductController::class);
});

