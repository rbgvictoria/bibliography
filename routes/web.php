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

Auth::routes();

Route::get('/', 'Controller@getHomePage');

Route::resource('references', 'ReferenceController')->only(['index', 'show']);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', function() {
        $info = ['auth' => Auth::check()];
        if (Auth::check()) {
            $info['user'] = [
                'id' => Auth::user()->getId(),
                'name' => Auth::user()->getName()
            ];
        }
        return response()->json($info);
});

