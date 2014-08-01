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

Route::get('/', function()
{
	return View::make('index', array('embed' => false));
});

Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::post('login', array('uses' => 'HomeController@doLogin'));
Route::get('logout', array('uses' => 'HomeController@doLogout', 'as' => 'logout'));
Route::get('help', array('uses' => 'HomeController@showHelp', 'as' => 'help'));
Route::get('embed', array('uses' => 'HomeController@showEmbed', 'as' => 'embed'));
Route::get('error', array('uses' => 'HomeController@showError', 'as' => 'error'));


// =============================================
// API ROUTES ==================================
// =============================================
Route::group(array('prefix' => 'api'), function() {
  Route::resource('seasons', 'SeasonController', array('only' => array('index')));
  Route::resource('heats', 'HeatController', array('only' => array('index')));
  Route::resource('games', 'GameController', array('only' => array('show', 'update', 'destroy')));

  Route::resource('groups', 'GroupController', array('only' => array('show', 'update')));
  Route::post('groups/{code}/games', array('uses' => 'GroupController@store_game', 'as' => 'groups.store_game'));

});

// =============================================
// ADMIN ROUTES ==================================
// =============================================
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function() {

  Route::get('', array('uses' => 'HomeController@home', 'as' => 'admin.index'));

  // Machines
  Route::resource('machines', 'AdminMachineController', array('only' => array('index', 'edit', 'update', 'create', 'store')));
  Route::post('machines/{machine_id}/activate', array('before' => 'auth', 'uses' => 'AdminMachineController@activate', 'as' => 'machines.activate'));
  Route::post('machines/{machine_id}/deactivate', array('before' => 'auth', 'uses' => 'AdminMachineController@deactivate', 'as' => 'machines.deactivate'));

  // Players
  Route::resource('players', 'AdminPlayerController', array('only' => array('index', 'edit', 'update', 'create', 'store')));

  // Activity log
  Route::resource('activities', 'AdminActivityController', array('only' => array('index')));

  // Seasons
  Route::get('seasons/{season_id}/players', array('uses' => 'AdminSeasonController@players', 'as' => 'admin.seasons.players'));
  Route::put('seasons/{season_id}/players', array('uses' => 'AdminSeasonController@update_players', 'as' => 'admin.seasons.update_players'));
  Route::post('seasons/{season_id}/store_heat', array('uses' => 'AdminSeasonController@store_heat', 'as' => 'admin.seasons.store_heat'));

  // Heats
  Route::get('heats/current', array('uses' => 'AdminHeatController@current', 'as' => 'admin.heats.current'));
  Route::resource('heats', 'AdminHeatController', array('only' => array('show', 'edit', 'update', 'create', 'store')));
  Route::post('heats/{heat_id}/groups', array('before' => 'auth', 'uses' => 'AdminHeatController@store_groups', 'as' => 'admin.heats.store_groups'));
  Route::delete('heats/{heat_id}/groups', array('before' => 'auth', 'uses' => 'AdminHeatController@destroy_groups', 'as' => 'admin.heats.destroy_groups'));
  Route::get('heats/{heat_id}/print', array('before' => 'auth', 'uses' => 'AdminHeatController@print_groups', 'as' => 'admin.heats.print'));
  Route::post('heats/{heat_id}/activate', array('before' => 'auth', 'uses' => 'AdminHeatController@activate', 'as' => 'heats.activate'));
  Route::post('heats/{heat_id}/deactivate', array('before' => 'auth', 'uses' => 'AdminHeatController@deactivate', 'as' => 'heats.deactivate'));

});

// =============================================
// CATCH ALL ROUTE =============================
// =============================================
// all routes that are not home or api will be redirected to the frontend
// this allows angular to route them
App::missing(function($exception)
{
  return View::make('index', array('embed' => false));
});
