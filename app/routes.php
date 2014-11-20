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
  Route::get('seasons', array('uses' => 'SeasonController@json_index'));
  Route::get('seasons/{season_id}', array('uses' => 'SeasonController@json_show'));
  Route::get('heats', array('uses' => 'HeatController@json_index'));
  Route::resource('games', 'GameController', array('only' => array('show', 'update', 'destroy')));
  Route::resource('players', 'PlayerController', array('only' => array('show')));

  Route::resource('groups', 'GroupController', array('only' => array('show', 'update')));
  Route::post('groups/{code}/games', array('uses' => 'GroupController@store_game', 'as' => 'groups.store_game'));

});

// =============================================
// PUBLIC ROUTES ===============================
// =============================================
Route::resource('standings', 'SeasonController', array('only' => array('index', 'show')));
Route::resource('results', 'HeatController', array('only' => array('index', 'show')));
Route::get('groups/{group_id}', array('uses' => 'GroupController@show_single', 'as' => 'groups.public'));

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

  // Groups
  Route::resource('groups', 'AdminGroupController', array('only' => array('show', 'edit')));
  Route::put('groups/{group_id}/players', array('uses' => 'AdminGroupController@update_players', 'as' => 'admin.groups.update_players'));
  Route::put('groups/{group_id}/results', array('uses' => 'AdminGroupController@update_results', 'as' => 'admin.groups.update_results'));

  // Stats
  Route::get('stats/activities', array('uses' => 'AdminStatsController@activities', 'as' => 'admin.stats.activities'));
  Route::get('stats/machines', array('uses' => 'AdminStatsController@machines', 'as' => 'admin.stats.machines'));

  // Seasons
  Route::resource('seasons', 'AdminSeasonController', array('only' => array('index', 'show', 'create', 'store', 'edit', 'update')));
  Route::get('seasons/{season_id}/players', array('uses' => 'AdminSeasonController@players', 'as' => 'admin.seasons.players'));
  Route::put('seasons/{season_id}/players', array('uses' => 'AdminSeasonController@update_players', 'as' => 'admin.seasons.update_players'));
  Route::post('seasons/{season_id}/store_heat', array('uses' => 'AdminSeasonController@store_heat', 'as' => 'admin.seasons.store_heat'));
  Route::get('seasons/{season_id}/positions', array('uses' => 'AdminSeasonController@positions', 'as' => 'admin.seasons.positions'));
  Route::put('seasons/{season_id}/positions', array('uses' => 'AdminSeasonController@update_positions', 'as' => 'admin.seasons.update_positions'));
  Route::get('seasons/{season_id}/ifpa', array('uses' => 'AdminSeasonController@ifpa', 'as' => 'admin.seasons.ifpa'));

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
