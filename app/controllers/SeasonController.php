<?php

class SeasonController extends \BaseController {

  public function index()
  {
    $seasons = Season::orderBy('created_at', 'desc')->get();
    return View::make('public.seasons.show', array('season' => $this->sorted_response(), 'seasons' => $seasons));
  }

  public function show($season_id)
  {
    $seasons = Season::orderBy('created_at', 'desc')->get();
    return View::make('public.seasons.show', array('season' => $this->sorted_response($season_id), 'seasons' => $seasons));
  }

	public function json_index()
	{
    return Response::json($this->common_response());
	}

  public function json_show($id)
  {

    return Response::json($this->common_response($id));
  }

  public function sorted_response($season_id = null)
  {
    $response = $this->common_response($season_id);

    // Sort points.
    if ($response['should_adjust_score']) {
      usort($response['points'], function($a, $b) {
        if ($a['adjusted_points'] == $b['adjusted_points']) {
          return 0;
        }
        return ($a['adjusted_points'] < $b['adjusted_points']) ? 1 : -1;
      });
    }
    else {
      usort($response['points'], function($a, $b) {
        if ($a['points'] == $b['points']) {
          return 0;
        }
        return ($a['points'] < $b['points']) ? 1 : -1;
      });
    }

    // Set positions on points
    $position = null;
    $position_points = null;
    $count = 0;
    foreach ($response['points'] as $index => $value) {
      $points = $response['should_adjust_score'] ? $value['adjusted_points'] : $value['points'];
      $count++;
      if ($position_points === $points) {
        $response['points'][$index]['position'] = ' ';
      }
      else {
        $position = $index;
        $position_points = $points;
        $response['points'][$index]['position'] = $count;
      }
    }

    // Key players by player_id
    $players = array();
    foreach ($response['players'] as $player) {
      $players[$player['player_id']] = $player;
    }
    $response['players'] = $players;

    // Key heat points by player_id
    foreach ($response['heats'] as $index => $heat) {
      $points = array();
      foreach ($heat['points'] as $point) {
        $points[$point['player_id']] = $point['points'];
      }
      $response['heats'][$index]['points'] = $points;
    }

    return $response;
  }

  public function common_response($season_id = null)
  {
    $season = null;

    if (!$season_id) {
      $season = Season::where('status', '=', 'active')->orderBy('created_at')->get()->first();
      $season_id = $season->season_id;
    }

    if (Cache::has('season-points-'.$season_id)) {
      if (!$season) {
        $season = Season::find($season_id);
      }

      $response = $season->toArray();
      $response['players'] = Cache::get('season-players-'.$season_id);
      $response['heats'] = Cache::get('season-heats-'.$season_id);
      $response['points'] = Cache::get('season-points-'.$season_id);
      $response['should_adjust_score'] = Cache::get('season-adjust-score-'.$season_id);

    } else {
      $season = Season::with('players', 'heats', 'heats.groups', 'heats.groups.players', 'heats.groups.games', 'heats.groups.games.results')->find($season_id);

      $season->heats->sortBy('delta');

      $season->set_group_player_number_on_results();

      // Return it with players, heats and points
      $response = $season->toArray();

      // Remove "groups" from "heats" to keep payload small
      foreach ($response['heats'] as $index => $heat) {
        unset($response['heats'][$index]['groups']);
        $h = $season->heats->find($heat['heat_id']);
        $response['heats'][$index]['points'] = $h->points();
      }

      $response['points'] = $season->points();
      $response['should_adjust_score'] = $season->should_adjust_score();

      Cache::forever('season-players-'.$season_id, $response['players']);
      Cache::forever('season-heats-'.$season_id, $response['heats']);
      Cache::forever('season-points-'.$season_id, $response['points']);
      Cache::forever('season-adjust-score-'.$season_id, $response['should_adjust_score']);

    }

    return $response;
  }

}
