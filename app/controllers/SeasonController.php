<?php

class SeasonController extends \BaseController {

	public function index()
	{
    // Find active season
    $season = Season::with('players', 'heats', 'heats.groups', 'heats.groups.players', 'heats.groups.games', 'heats.groups.games.results')->where('status', '=', 'active')->orderBy('created_at')->get()->first();

    return $this->common_response($season);
	}

  public function show($id)
  {
    $season = Season::with('players', 'heats', 'heats.groups', 'heats.groups.players', 'heats.groups.games', 'heats.groups.games.results')->find($id);

    return $this->common_response($season);
  }

  public function common_response($season)
  {
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

    return Response::json($response);
  }

}
