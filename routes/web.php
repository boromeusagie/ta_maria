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

Route::get('/', 'WelcomeController@index')->name('welcome');

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

        // Routes for pembelian
        Route::group(
            ['prefix' => 'pembelian'], function() {
                Route::get('order', 'PembelianController@orderPembelian')->name('pembelian.order');
                Route::post('order', 'PembelianController@store')->name('pembelian.store');
                Route::get('order/{id}', 'PembelianController@orderPembelianShow')->name('pembelian.ordershow');
                Route::post('order/{id}', 'PembelianController@orderPembelianStore')->name('pembelian.orderstore');
                Route::get('order/getSatuan/{kodeBarang}', 'PembelianController@getSatuan')->name('pembelian.getsatuan');
                Route::delete('order/{id}/{itemId}/delete', 'PembelianController@itemDestroy')->name('pembelian.itemdestroy');
            }
        );

        // Routes for penjualan
        Route::group(
            ['prefix' => 'penjualan'], function() {
                Route::get('no', 'PenjualanController@orderPenjualan')->name('penjualan.order');
                Route::post('no', 'PenjualanController@store')->name('penjualan.store');
                Route::get('no/{id}', 'PenjualanController@orderPenjualanShow')->name('penjualan.ordershow');
                Route::post('no/{id}', 'PenjualanController@orderPenjualanStore')->name('penjualan.orderstore');
                Route::post('no/{id}/cashier', 'PenjualanController@cashierPenjualan')->name('penjualan.cashier');
                Route::get('no/getSatuan/{kodeBarang}', 'PenjualanController@getSatuan')->name('penjualan.getsatuan');
                Route::delete('no/{id}/{itemId}/delete', 'PenjualanController@itemDestroy')->name('penjualan.itemdestroy');
            }
        );
        
        // Routes for penerimaan barang
        Route::group(
            ['prefix' => 'penerimaan-barang'], function() {
                Route::get('', 'PenerimaanBarangController@index')->name('penerimaan-barang.index');
                Route::get('{id}', 'PenerimaanBarangController@show')->name('penerimaan-barang.show');
                Route::get('{id}/{idItem}', 'PenerimaanBarangController@terimaBarang')->name('penerimaan-barang.terima');
            }

        );

        // Routes for return-pembelian
        Route::group(
            ['prefix' => 'return-pembelian'], function() {
                Route::get('', 'ReturnPembelianController@index')->name('return-pembelian.index');
                Route::get('{id}', 'ReturnPembelianController@show')->name('return-pembelian.show');
                Route::post('{id}/return', 'ReturnPembelianController@return')->name('return-pembelian.return');
            }

        );

        // Routes for laporan
        Route::group(
            ['prefix' => 'cetak-laporan'], function() {
                Route::get('', 'LaporanCOntroller@index')->name('laporan.index');
                Route::get('cetak', 'LaporanCOntroller@cetakPdf')->name('laporan.cetak');
            }

        );

    }
);
