<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchMenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\ChefResponsibilityController;
use App\Http\Controllers\CombomenuRequestController;
use App\Http\Controllers\CookbookCategoryController;
use App\Http\Controllers\CookbookItemController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MenuitemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
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
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::post('/reqcombomenu', [FrontController::class, 'reqcombomenu'])->name('reqcombomenu');

//Shop
Route::get('/shop/{id}/{location}', [FrontController::class, 'shop'])->name('shop');
Route::get('/changebranch', [FrontController::class, 'changebranch'])->name('changebranch');
Route::get('/shopdetails/{id}/{slug}', [FrontController::class, 'shopdetails'])->name('shopdetails');

//Cart
Route::post('/addtocart/{id}', [FrontController::class, 'addtocart'])->name('addtocart');
Route::get('/cart', [FrontController::class, 'cart'])->name('cart');
Route::put('/updatequantity/{id}', [FrontController::class, 'updatequantity'])->name('updatequantity');
Route::get('/removefromcart/{id}', [FrontController::class, 'removefromcart'])->name('removefromcart');

//Checkout
Route::get('/checkout/{id}', [FrontController::class, 'checkout'])->name('checkout');
Route::post('/placeorder', [FrontController::class, 'placeorder'])->name('placeorder');

//Review
Route::post('/addreview', [FrontController::class, 'addreview'])->name('addreview');
Route::put('/updatereview/{id}', [FrontController::class, 'updatereview'])->name('updatereview');
Route::delete('/deleteuserreview/{id}', [FrontController::class, 'deleteuserreview'])->name('deleteuserreview');

//User
Route::get('/myaccount', [FrontController::class, 'myaccount'])->name('myaccount');
Route::get('/editcustomeraddress', [FrontController::class, 'editcustomeraddress'])->name('editcustomeraddress');
Route::put('/updateaddress/{id}', [FrontController::class, 'updateaddress'])->name('updateaddress');
Route::get('/myprofile', [FrontController::class, 'myprofile'])->name('myprofile');
Route::get('/editinfo', [FrontController::class, 'editinfo'])->name('editinfo');
Route::get('/sendemailchange', [FrontController::class, 'sendemailchange'])->name('sendemailchange');
Route::get('/useremailchange', [FrontController::class, 'useremailchange'])->name('user.emailchange');
Route::get('/send-otpemail', [FrontController::class, 'sendotpEmail'])->name('sendotp');
Route::get('/otpvalidation', [FrontController::class, 'otpvalidation'])->name('otpvalidation');
Route::put('/updatepassword', [FrontController::class, 'updatePassword'])->name('updatepassword');
Route::get('/myorders', [FrontController::class, 'myorders'])->name('myorders');
Route::put('/cancelorder/{id}', [FrontController::class, 'cancelorder'])->name('cancelorder');
Route::get('/myreviews', [FrontController::class, 'myreviews'])->name('myreviews');

//Customer Email
Route::get('/customerEmail', [FrontController::class, 'customerEmail'])->name('customerEmail');

//Blog
Route::get('/getblogs', [FrontController::class, 'getblogs'])->name('getblogs');
Route::get('/getblogdetail/{id}', [FrontController::class, 'getblogdetail'])->name('getblogdetail');
Route::get('/categoryblog/{id}/{slug}', [FrontController::class, 'categoryblog'])->name('categoryblog');
Route::get('/authorblogs/{name}', [FrontController::class, 'authorblogs'])->name('authorblog');

//CookBook
Route::get('/getrecipes', [FrontController::class, 'getrecipes'])->name('getrecipes');
Route::get('/getrecipedetail/{id}/{slug}', [FrontController::class, 'getrecipedetail'])->name('getrecipedetail');
Route::get('/categorycookbookrecipe/{id}/{slug}', [FrontController::class, 'categorycookbookrecipe'])->name('categorycookbookrecipe');
Route::get('/authorrecipe/{name}', [FrontController::class, 'authorrecipe'])->name('authorrecipe');

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

    //Combo Menuitem
    Route::get('/combomenu', [MenuitemController::class, 'combomenu'])->name('combomenu.index');
    Route::get('/combomenu/create', [MenuitemController::class, 'combomenucreate'])->name('combomenu.create');
    Route::post('/combomenu/store', [MenuitemController::class, 'combomenustore'])->name('combomenu.store');
    Route::get('/combomenu/{id}/edit', [MenuitemController::class, 'combomenuedit'])->name('combomenu.edit');
    Route::put('/combomenu/{id}/update', [MenuitemController::class, 'combomenuupdate'])->name('combomenu.update');
    Route::delete('/combomenu/{id}/delete', [MenuitemController::class, 'combomenudestroy'])->name('combomenu.destroy');

    Route::resource('combomenuRequest', CombomenuRequestController::class);


    //Review
    Route::resource('review', ReviewController::class);
    Route::put('enablereview/{id}', [ReviewController::class, 'enableurl'])->name('review.enable');
    Route::put('disablereview/{id}', [ReviewController::class, 'disableurl'])->name('review.disable');

    //Order
    Route::resource('order', OrderController::class);
    Route::put('/addproductorder', [OrderController::class, 'addproductorder'])->name('addproductorder');
    Route::get('/deletefromorder/{id}', [OrderController::class, 'deletefromorder'])->name('deletefromorder');
    Route::put('/updatequantityadmin/{id}', [OrderController::class, 'updatequantityadmin'])->name('updatequantityadmin');
    Route::put('/editaddress/{id}', [OrderController::class, 'editaddress'])->name('editaddress');
    Route::put('/changeOrderStatus/{id}', [OrderController::class, 'changeOrderStatus'])->name('changeOrderStatus');
    Route::put('/productorder', [OrderController::class, 'productorder'])->name('productorder');

    //Settings
    Route::resource('setting', SettingController::class);
    Route::resource('slider', SliderController::class);

    //Blogs
    Route::resource('blogcategory', BlogCategoryController::class);
    Route::resource('blog', BlogController::class);

    //Cookbook
    Route::resource('cookbookcategory', CookbookCategoryController::class);
    Route::resource('cookbookitem', CookbookItemController::class);

    // Route::resource('product', ProductController::class);
});

