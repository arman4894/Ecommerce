<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontProductListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;

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
Auth::routes();





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin',[App\Http\Controllers\AdminController::class,'index']);
Route::get('/subcategories/{id}',[ProductController::class,'loadSubCategories']);

// backend part
Route::group(['prefix'=>'auth','middleware'=>['auth','isAdmin']],function(){

    Route::get('/dashboard',function(){
            return view('admin.dashboard');
        });
    Route::resource('/category',CategoryController::class);
    Route::resource('/subcategory',SubcategoryController::class);
    Route::resource('/product',ProductController::class);
    Route::get('slider/create',[SliderController::class,'create'])->name('slider.create');
    Route::get('slider',[SliderController::class,'index'])->name('slider.index');
    Route::post('slider',[SliderController::class,'store'])->name('slider.store');
    Route::delete('slider/{id}',[SliderController::class,'destroy'])->name('slider.destroy');
    Route::get('users',[UserController::class,'index'])->name('user.index');
    Route::get('orders',[CartController::class,'userOrder'])->name('order.index');
    Route::get('orders/{userid}/{orderid}',[CartController::class,'viewUserOrder'])->name('user.order');

});
// frontend part
Route::get('/',[FrontProductListController::class,'index']);
Route::get('/product/{id}',[FrontProductListController::class,'show'])->name('product.show');
Route::get('/category/{name}',[FrontProductListController::class,'allProduct'])->name('product.list');
Route::get('/addTocart/{product}',[CartController::class,'addToCart'])->name('add.cart');
Route::get('/cart',[CartController::class,'showCart'])->name('cart.show');
Route::post('/products/{product}',[CartController::class,'updateCart'])->name('cart.update');
Route::post('/product/{product}',[CartController::class,'removeCart'])->name('cart.remove');
Route::get('all/product',[FrontProductListController::class,'moreProducts'])->name('more.products');


Route::get('/checkout/{amount}',[CartController::class,'checkout'])->name('cart.checkout')->middleware('auth');
Route::post('/charge',[CartController::class,'charge'])->name('charge');
Route::get('orders',[CartController::class,'order'])->name('order')->middleware('auth');
