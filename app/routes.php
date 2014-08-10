<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('connect', 'ConnectController');

Route::controller('auth', 'AuthController');

Route::controller('site', 'Dashboard\\SiteController');

Route::controller('balance', 'Dashboard\\BalanceController');


if (Auth::guest()) {
    Route::controller('/', 'HomeController');
} else {
    Route::controller('/', 'DashboardController');
}

//Route::any('/', array('before' => 'auth', 'uses' => 'DashboardController@getIndex'));
