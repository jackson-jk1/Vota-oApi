<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/athenticated', function () {
    return true;
});

Route::post('/store','App\Http\Controllers\EnqueteController@store');
Route::get('/index','App\Http\Controllers\EnqueteController@index');
Route::post('/update/{id}','App\Http\Controllers\EnqueteController@update');
Route::post('/destroy/{id}','App\Http\Controllers\EnqueteController@destroy');


Route::post('/store/opcoes/{id}','App\Http\Controllers\OpcaoController@store');
Route::post('/update/opcoes/{id}','App\Http\Controllers\OpcaoController@update');
Route::post('/destroy/opcoes/{id}','App\Http\Controllers\OpcaoController@destroy');
Route::post('/removeVoto/opcoes/{id}','App\Http\Controllers\OpcaoController@removeVoto');
Route::post('/voto/opcao/{id}','App\Http\Controllers\OpcaoController@voto');


Route::post('/register','App\Http\Controllers\UserController@store');
Route::post('/login','App\Http\Controllers\UserController@login');
Route::post('/logout','App\Http\Controllers\UserController@logout');

Route::post('/view/{id}','App\Http\Controllers\PagesController@view');
Route::get('/show','App\Http\Controllers\PagesController@show');
Route::post('/view/opcao/{id}','App\Http\Controllers\OpcaoController@view');
