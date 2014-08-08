<?php

class HeatController extends \BaseController {

	public function index()
	{

		// Find all heats from the active season
		$season = Season::with('heats', 'heats.groups', 'heats.groups.games', 'heats.groups.players', 'heats.groups.games.machine')->where('status', '=', 'active')->orderBy('created_at')->get()->first();
		$season->heats->sortBy('delta');

    $season->set_group_player_number_on_results();

		// Only include heats before the current active one
		// As well as heats that have groups
		$heats = array();
		foreach ($season->heats as $heat) {
			if (count($heat->groups) > 0) {
				$heats[] = $heat->toArray();
			}
			if ($heat->status === 'active') {
				break;
			}
		}

		$response = array();
		$response['season'] = $season->toArray();
		$response['heats'] = array_reverse($heats);

		return Response::json($response);

	}

}
