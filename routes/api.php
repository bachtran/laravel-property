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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('properties')->group(function () {
    /*
     * Get all properties
     */
    Route::get('/', 'PropertyController@index')->name('properties.index');

    /*
     * Get property details
     */
    Route::get('/{id}', 'PropertyController@show');

    /*
     * Add property
     */
    Route::post('/', 'PropertyController@store');

    /*
     * Get property's analytics
     */
    Route::get('/{id}/analytics', 'PropertyController@get_analytics');

    /*
     * Add or update analytic to a property
     */
    Route::post('/{property_id}/analytics/{analytic_id}', 'PropertyController@add_analytic');
});

Route::prefix('analytics')->group(function () {
    /*
     * Get all analytics
     */
    Route::get('/', 'AnalyticController@index');

    /*
     * Get analytic details
     */
    Route::get('/{id}', 'AnalyticController@show');

    /*
     * Add analytic
     */
    Route::post('/', 'AnalyticController@store');

    /*
     * Analytic summary routes
     */
    Route::get('/summary/suburb/{suburb}', 'AnalyticController@summary_by_suburb');

    Route::get('/summary/state/{state}', 'AnalyticController@summary_by_state');

    Route::get('/summary/country/{country}', 'AnalyticController@summary_by_country');
});
