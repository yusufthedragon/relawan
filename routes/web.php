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

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/about-us', 'HomeController@about')->name('about-us');

Route::get('/posko', 'PlaceController@index')->name('daftar-posko');
Route::get('/posko/{slug}', 'PlaceController@detail')->name('detail-posko');

Route::post('/search', 'HomeController@search')->name('search');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/terms-and-conditions', 'HomeController@trc')->name('trc');
Route::get('/privacy-policy', 'HomeController@privacypolicy')->name('privacy-policy');
Route::match(array('GET', 'POST'), '/contact-us', 'HomeController@contact')->name('contact');


Route::name('admin.')->middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', 'HomeController@admin')->name('home');
    
    Route::name('references.')->middleware('auth')->prefix('references')->group(function () {
    
        Route::name('posko.')->prefix('posko')->group(function () {
            Route::get('/', 'References\PlaceController@index')->name('index');
            Route::get('/add', 'References\PlaceController@create')->name('add');
            Route::post('/add', 'References\PlaceController@save')->name('save');
            Route::post('/import', 'References\PlaceController@importGeoJson')->name('importgeo');
            Route::get('/edit/{id}', 'References\PlaceController@edit')->name('edit');
            Route::post('/edit/{id}', 'AdminController@updatePosko')->name('update');
        });
        
        Route::name('place.')->prefix('place')->group(function () {
            Route::post('/save-bulk', 'References\PlaceController@store')->name('bulk');
            Route::get('/save-bulk', 'References\PlaceController@store')->name('bulk');
        });
    });
});

