<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->getName();
});

Route::get('/', function() {
    return view('swagger');
});
Route::get('/swagger.json', 'API\\ApiController@apiDocs');

Route::get('agents/findByName', 'API\\AgentController@findByName');

Route::get('references/{reference}', 'API\\ReferenceController@show');
Route::get('citations', 'API\\ReferenceController@getCitations');
Route::get('autocomplete/reference', 'API\\ReferenceController@autocomplete');
Route::get('autocomplete/author', 'API\\AuthorController@autocomplete');
Route::get('autocomplete/journal', 'API\\ReferenceController@autocompleteJournal');
Route::get('autocomplete/book', 'API\\ReferenceController@autocompleteBook');

Route::middleware('auth:api')->post('/agents', 'API\\AgentController@store');
Route::middleware('auth:api')->put('/references/{reference}', 'API\\ReferenceController@update');
