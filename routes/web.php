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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/generate-pdf', 'HomeController@generatePDF')->name('generate-pdf');
    Route::get('/preview', 'HomeController@preview')->name('preview');;
    Route::get('/download', 'HomeController@download')->name('download');


    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::post('/saveCookie', 'HomeController@saveCookie')->name('saveCookie');
        Route::post('/saveAvatar', 'HomeController@saveAvatar')->name('saveAvatar');
        Route::get('users/export','HomeController@export' )->name('UsersExport');
        Route::post('users/import','HomeController@import' )->name('UsersImport');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

    });
});
