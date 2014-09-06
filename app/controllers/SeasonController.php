<?php

class SeasonController extends \BaseController {

	public function index()
	{
    return $this->common_response();
	}

  public function show($id)
  {

    return $this->common_response($id);
  }

  public function common_response($season_id = null)
  {
    $season = null;

    if (!$season_id) {
      $season = Season::where('status', '=', 'active')->orderBy('created_at')->get()->first();
      $season_id = $season->season_id;
    }

    if (Cache::has('season-players-'.$season_id)) {
      if (!$season) {
        $season = Season::find($season_id);
      }

      $response = $season->toArray();
      $response['players'] = Cache::get('season-players-'.$season_id);
      $response['heats'] = Cache::get('season-heats-'.$season_id);
      $response['points'] = Cache::get('season-points-'.$season_id);

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

    }

    return Response::json($response);
  }

}
