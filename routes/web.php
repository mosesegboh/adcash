<?php

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

//route for adding stock
Route::post('/stock', 'StockController@store')->name('stock');

//route for adding a new client
Route::post('/client', 'StockController@clientStore')->name('client');

//route for editing stock
Route::get('/editstock/{stock_id}', 'StockController@edit')->name('editstock');

//route for updating stock
Route::post('/updatestock/{stock_id}', 'StockController@update')->name('updatestock');

//route for viewing stocks
Route::get('/viewstock/{clientid}', 'StockController@show')->name('viewstock');

//route for purchasing stock
Route::post('/purchasestock', 'StockController@purchaseStock')->name('purchasestock');

//route for deleting stock
Route::get('/deletestock/{stock_id}', 'StockController@destroy')->name('deletestock');

