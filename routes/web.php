<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/dashboard','App\Http\Controllers\ProductController@dashboard')->name('Dashboard');
    Route::get('/products','App\Http\Controllers\ProductController@list')->name('products');
    Route::get('/product/{sku}','App\Http\Controllers\ProductController@getBySku')->name('product.sku');

    Route::get('/magnum','App\Http\Controllers\ProductController@magnum')->name('magnum');
    Route::get('/magnum_update','App\Http\Controllers\ProductController@magnum_update')->name('magnum.update');

    Route::get('/export','App\Http\Controllers\ProductController@export')->name('product.export');
    Route::get('/update/{target}/{selected}','App\Http\Controllers\ProductController@updateShop')->name('product.shop.update');
    Route::get('/remove/{id}','App\Http\Controllers\ProductController@remove')->name('product.shop.remove');

    Route::post('/update','App\Http\Controllers\ProductController@update')->name('product.update');
    Route::post('/store','App\Http\Controllers\ProductController@store')->name('product.store');
    Route::get('/shop/search/{value}','App\Http\Controllers\ProductController@shopSearch')->name('shop.search');
});

Route::get('/logout', 'App\Http\Controllers\Controller@logout');

Route::get('/cron','App\Http\Controllers\ProductController@stockUpdate')->name('cron.update');
Route::get('/cron/shop/{id}','App\Http\Controllers\ProductController@cronShopPrice')->name('cron.shop.update');

Route::get('/reset/shop','App\Http\Controllers\ProductController@resetShop')->name('shop.reset');

Route::get('/product/id/{id}','App\Http\Controllers\ProductController@getById');




