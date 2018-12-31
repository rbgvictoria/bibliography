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
    return view('app');
});

Route::get('/test', function () {
    return view('app');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('references', 'ReferenceController')->only(['index', 'show']);

Route::middleware('auth.api')->resource('references', 'ReferenceController')
        ->except(['index', 'show']);
