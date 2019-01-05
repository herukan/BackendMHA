<?php

use Illuminate\Http\Request;

//FIX CORS
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');


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
    return $request->user();
});

//CRUD Asassment

Route::get('asassment', array('middleware' => 'cors', 'uses' => 'AsassmentController@index'));

//ALL COUNT
Route::get('asassmentcount', array('middleware' => 'cors', 'uses' => 'AsassmentController@allcount'));

Route::get('asassment/{id}',array('middleware' => 'cors', 'uses' => 'AsassmentController@select'));

Route::get('countkerusakanbytingkat', array('middleware' => 'cors', 'uses' => 'AsassmentController@countkerusakanbytingkat'));
Route::get('countkerusakanbybagian', array('middleware' => 'cors', 'uses' => 'AsassmentController@countkerusakanbybagian'));
Route::get('countkerusakanbykab', array('middleware' => 'cors', 'uses' => 'AsassmentController@countkerusakanbykab'));
Route::get('countkerusakanbykec', array('middleware' => 'cors', 'uses' => 'AsassmentController@countkerusakanbykec'));


//KERUSAKAN PER KEC DAN KAB
Route::get('counttingkatkerusakanbyperkec', array('middleware' => 'cors', 'uses' => 'AsassmentController@counttingkatkerusakanbyperkec'));
Route::get('counttingkatkerusakanbyperkab', array('middleware' => 'cors', 'uses' => 'AsassmentController@counttingkatkerusakanbyperkab'));

Route::post('asassment',array('middleware' => 'cors', 'uses' => 'AsassmentController@create'));
Route::delete('/asassment/{id}',array('middleware' => 'cors', 'uses' => 'AsassmentController@delete'));
Route::put('/asassment/{id}',array('middleware' => 'cors', 'uses' => 'AsassmentController@update'));

Route::post('/tesgcp',array('middleware' => 'cors', 'uses' => 'AsassmentController@tesgcp'));

Route::post('/tesaws',array('middleware' => 'cors', 'uses' => 'AsassmentController@tesaws'));

Route::get('/countstatus',array('middleware' => 'cors', 'uses' => 'AsassmentController@countstatus'));


Route::get('/countharga',array('middleware' => 'cors', 'uses' => 'AsassmentController@countharga'));

Route::get('/counthargakab',array('middleware' => 'cors', 'uses' => 'AsassmentController@counthargakab'));

Route::get('/counthargakec',array('middleware' => 'cors', 'uses' => 'AsassmentController@counthargakec'));

Route::get('/tingkatdikab',array('middleware' => 'cors', 'uses' => 'AsassmentController@tingkatdikab'));

Route::get('/countstatusperkab',array('middleware' => 'cors', 'uses' => 'AsassmentController@countstatusperkab'));