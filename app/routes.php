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



if (Auth::guest()) {
    
    Route::controller('/', 'HomeController');
    
} elseif (Auth::user()->isAdmin()) {
    
    Route::resource('admin/rest/tickets', 'Admin\\Rest\\TicketsController');

    Route::resource('admin/rest/merchants', 'Admin\\Rest\\MerchantsController');

    Route::resource('admin/rest/sites', 'Admin\\Rest\\SitesController');

    Route::resource('admin/rest/visitors', 'Admin\\Rest\\VisitorsController');

    Route::resource('admin/rest/collections', 'Admin\\Rest\\CollectionsController');
    Route::controller('collections', 'Admin\\CollectionsController');
    
    Route::controller('/', 'Admin\\IndexController');
    
} else {
    
    Route::controller('site', 'Dashboard\\SiteController');

    Route::controller('balance', 'Dashboard\\BalanceController');
    
    Route::get('help/{markdown?}', 'Dashboard\\HelpController@getMarkdown');

    Route::controller('support', 'Dashboard\\SupportController');

    Route::controller('/', 'DashboardController');
}

//Route::any('/', array('before' => 'auth', 'uses' => 'DashboardController@getIndex'));
