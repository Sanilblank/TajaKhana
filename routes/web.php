<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchMenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\ChefResponsibilityController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenuitemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
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

//Shop
Route::get('/shop/{id}/{location}', [FrontController::class, 'shop'])->name('shop');
Route::get('/changebranch', [FrontController::class, 'changebranch'])->name('changebranch');
Route::get('/shopdetails/{id}/{slug}', [FrontController::class, 'shopdetails'])->name('shopdetails');

//Cart
Route::post('/addtocart/{id}', [FrontController::class, 'addtocart'])->name('addtocart');
Route::get('/cart', [FrontController::class, 'cart'])->name('cart');
Route::put('/updatequantity/{id}', [FrontController::class, 'updatequantity'])->name('updatequantity');
Route::get('/removefromcart/{id}', [FrontController::class, 'removefromcart'])->name('removefromcart');





Auth::routes();

Route::get('/verify', [RegisterController::class, 'verifyUser'])->name('verify.user');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 Route::group(['middleware' => ['auth']], function() {
    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('category', CategoryController::class);


    //Branch
    Route::resource('branch', BranchController::class);

    //Branch Menu
    Route::get('/branchmenu/{id}', [BranchMenuController::class, 'index'])->name('branchmenu.index');
    Route::get('/branchmenu/create/{id}', [BranchMenuController::class, 'create'])->name('branchmenu.create');
    Route::resource('branchmenu', BranchMenuController::class, ['except' => ['index', 'create']]);

    //Chef
    Route::resource('chef', ChefController::class);
    Route::get('/chefresponsibility/{id}', [ChefResponsibilityController::class, 'index'])->name('chefresponsibility.index');
    Route::get('/chefresponsibility/create/{id}', [ChefResponsibilityController::class, 'create'])->name('chefresponsibility.create');
    Route::resource('chefresponsibility', ChefResponsibilityController::class, ['except' => ['index', 'create']]);

    //Driver
    Route::resource('driver', DriverController::class);

    //Menu Item
    Route::resource('menuitem', MenuitemController::class);


    //Settings
    Route::resource('setting', SettingController::class);
    Route::resource('slider', SliderController::class);

    // Route::resource('product', ProductController::class);
});

