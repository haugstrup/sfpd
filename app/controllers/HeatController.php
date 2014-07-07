<?php

class HeatController extends \BaseController {

	public function index()
	{

		// Find all heats from the active season
		$season = Season::with('heats', 'heats.groups', 'heats.groups.games', 'heats.groups.players', 'heats.groups.games.machine')->where('status', '=', 'active')->orderBy('created_at')->get()->first();
		$season->heats->sortBy('delta');

		// Only include heats before the current active one.
		$heats = array();
		foreach ($season->heats as $heat) {
			if ($heat->status === 'active') {
				break;
			}
			$heats[] = $heat->toArray();
		}

		$response = array();
		$response['season'] = $season->toArray();
		$response['heats'] = array_reverse($heats);

		return Response::json($response);

	}

}
