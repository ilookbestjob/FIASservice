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



Route::get('/upload', function () {
    return view('upload');
});



Route::post('/upload/file', 'fileController@update');
Route::get('/upload/types', 'fileController@upadteFiasTypes');

Route::get('/upload/index', 'fileController@updateindex');
Route::post('/upload/fromuploaded', 'uploadedController@start');
Route::get('/upload/manage/stop', 'manageController@stop');

Route::get('/fix/district', 'fixController@fixdistrict');
Route::get('/fix/types', 'fixController@fixTypes');


Route::get('/apitest', function () {
    return view('apitest');
});

Route::get('/api/search/{level}/{search}',  'apiController@search');


Route::get('/fiasdialog', function () {
    return view('fiasdialog');
});


Route::get('/search/{txt}',  function ($txt) {
    return view('search',["text"=>$txt ]);   }   );


    
Route::get('/search',  function () {
    return view('search');   }   );

//////////маршруты fiasAPI


Route::get('/api/regions',  'apiController@getRegions'); //выбор всех регионов
Route::get('/api/cities/{region}',  'apiController@getCities'); //выбор всех регионов
Route::get('/api/streets/{city}',  'apiController@getStreets'); //выбор всех регионов
Route::get('/api/areas/{region}',  'apiController@getAreas'); //выбор всех районов
Route::get('/api/index/{street}/{house}',  'apiController@getIndex'); //поиск индекса
Route::get('/api/districts/{city}',  'apiController@getDistricts'); //поиск индекса

Route::get('/api/inn/{inn}',  'apiController@getByInn'); //поиск индекса

