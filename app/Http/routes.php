<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

// Authentication routes...
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/login', 'Auth\AuthController@getLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'ReportsController@index');
    Route::post('/', 'ReportsController@store');
    Route::post('/edit/{id}', 'ReportsController@edit');
    Route::post('/delete/{id}', 'ReportsController@destroy');
    Route::get('/reports/{from}/{to}', "ReportsController@reports");

    Route::get('/pdf', "ReportsController@pdf");
    Route::get('/pdf-period/{from}/{to}', "ReportsController@pdfPeriod");

});
