<?php

class SeasonController extends \BaseController {

  public function index()
  {
    $seasons = Season::orderBy('created_at', 'desc')->get();
    return View::make('public.seasons.show', array('season' => Season::sorted_points(), 'seasons' => $seasons));
  }

  public function show($season_id)
  {
    $seasons = Season::orderBy('created_at', 'desc')->get();
    return View::make('public.seasons.show', array('season' => Season::sorted_points($season_id), 'seasons' => $seasons));
  }

  public function playoffs($season_id)
  {
    $season = Season::find($season_id);
    $seasons = Season::where('status', '=', 'complete')->orderBy('created_at', 'desc')->get();

    $results = DB::table('player_season')
      ->select('players.player_id', 'player_season.final_position', 'players.display_name', 'player_season.rookie')
      ->join('players', 'players.player_id', '=', 'player_season.player_id')
      ->where('season_id', $season_id)
      ->orderBy('final_position', 'asc')
      ->get();

    return View::make('public.seasons.playoffs', array('season' => $season, 'seasons' => $seasons, 'results' => $results));
  }

}
