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

Route::get('/', 'HomeController@index');

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::post('resetPassword', 'HomeController@resetPassword');


//customers
Route::get('/customers', 'CustomerController@index');
Route::get('/customers/all', 'CustomerController@all');
Route::post('/customer/save', 'CustomerController@save');
Route::post('/customer/remove', 'CustomerController@remove');

//products
Route::get('/products', 'ProductController@index');
Route::post('/product/save', 'ProductController@save');
Route::post('/product/remove', 'ProductController@remove');

//orders
Route::get('/orders', 'OrderController@index');
Route::get('/order/products', 'OrderController@products');
Route::post('/order/save', 'OrderController@save');
Route::post('/order/remove', 'OrderController@remove');
Route::get('/order/info/{id}', 'OrderController@info');

//settings
Route::get('/settings', 'SettingController@index');
Route::post('/setting/save', 'SettingController@save');

//invoices
Route::get('/invoices', 'InvoiceController@index');
Route::get('/invoice/orders', 'InvoiceController@orders');
Route::get('/invoice/info/{id}', 'InvoiceController@info');
