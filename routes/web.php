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

Route::get('/', 'TestController@fetchEmail');
Route::get('/payment', 'TestController@sendPayment');
Route::post('/payment', 'TestController@sendEmail');
Route::get('/new-bank', 'TestController@newBankForm');
Route::post('/new-bank', 'TestController@newBankCreate');