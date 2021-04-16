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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(
    ['middleware' => 'auth'], function() {
        
        // Routes for user
        Route::group(
            ['prefix' => 'user'], function() {
                Route::get('', 'UserController@index')->name('user.index');
                Route::post('', 'UserController@store')->name('user.store');
                Route::delete('{id}', 'UserController@destroy')->name('user.destroy');
            }

        );

        // Routes for barang
        Route::group(
            ['prefix' => 'barang'], function() {
                Route::get('', 'BarangController@index')->name('barang.index');
                Route::post('', 'BarangController@store')->name('barang.store');
                Route::get('{id}','BarangController@edit')->name('barang.edit');
                Route::post('{id}','BarangController@update')->name('barang.update');
                Route::delete('{kodeBarang}', 'BarangController@destroy')->name('barang.destroy');
            }

        );

        // Routes for supplier
        Route::group(
            ['prefix' => 'supplier'], function() {
                Route::get('', 'SupplierController@index')->name('supplier.index');
                Route::post('', 'SupplierController@store')->name('supplier.store');
                Route::get('{id}','SupplierController@edit')->name('supplier.edit');
                Route::post('{id}','SupplierController@update')->name('supplier.update');
                Route::delete('{id}', 'SupplierController@destroy')->name('supplier.destroy');
            }

        );

        // Routes for penjualan
        Route::group(
            ['prefix' => 'penjualan'], function() {
                Route::get('', 'PenjualanController@index')->name('penjualan.index');
                Route::post('', 'PenjualanController@store')->name('penjualan.store');
                Route::get('{id}','PenjualanController@edit')->name('penjualan.edit');
                Route::post('{id}','PenjualanController@update')->name('penjualan.update');
                Route::delete('{id}', 'PenjualanController@destroy')->name('penjualan.destroy');
            }

        );

        // Routes for pembelian
        Route::group(
            ['prefix' => 'pembelian'], function() {
                Route::get('', 'PembelianController@index')->name('pembelian.index');
                Route::get('order', 'PembelianController@orderPembelian')->name('pembelian.order');
                Route::post('order', 'PembelianController@store')->name('pembelian.store');
                Route::get('order/{id}', 'PembelianController@orderPembelianShow')->name('pembelian.ordershow');
                Route::post('order/{id}', 'PembelianController@orderPembelianStore')->name('pembelian.orderstore');
                Route::get('order/getSatuan/{kodeBarang}', 'PembelianController@getSatuan')->name('pembelian.getsatuan');
                Route::get('{id}', 'PembelianController@edit')->name('pembelian.edit');
                Route::post('{id}', 'PembelianController@update')->name('pembelian.update');
                Route::delete('order/{id}/{itemId}/delete', 'PembelianController@itemDestroy')->name('pembelian.itemdestroy');
            }
        );

        // Routes for penjualan
        Route::group(
            ['prefix' => 'penjualan'], function() {
                Route::get('', 'PenjualanController@index')->name('penjualan.index');
                Route::get('no', 'PenjualanController@orderPenjualan')->name('penjualan.order');
                Route::post('no', 'PenjualanController@store')->name('penjualan.store');
                Route::get('no/{id}', 'PenjualanController@orderPenjualanShow')->name('penjualan.ordershow');
                Route::post('no/{id}', 'PenjualanController@orderPenjualanStore')->name('penjualan.orderstore');
                Route::get('no/getSatuan/{kodeBarang}', 'PenjualanController@getSatuan')->name('penjualan.getsatuan');
                Route::get('{id}', 'PenjualanController@edit')->name('penjualan.edit');
                Route::post('{id}', 'PenjualanController@update')->name('penjualan.update');
                Route::delete('no/{id}/{itemId}/delete', 'PenjualanController@itemDestroy')->name('penjualan.itemdestroy');
            }
        );
        

    }
);
