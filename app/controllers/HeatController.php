<?php

class HeatController extends \BaseController {

	public function index()
	{
		return $this->common_response();
	}

	public function show($heat_id)
	{
		return $this->common_response($heat_id);
	}

	public function common_response($heat_id = null)
	{
		$season = Season::where('status', '=', 'active')->orderBy('created_at')->get()->first();
		$heats = Heat::whereIn('status', array('active', 'completed'))->where('season_id', '=', $season->season_id)->orderBy('date', 'desc')->get();
		if ($heat_id) {
			$heat = Heat::with('groups', 'groups.games', 'groups.players', 'groups.games.machine', 'groups.games.results')->find($heat_id);
		}
		else {
			$heat = Heat::with('groups', 'groups.games', 'groups.players', 'groups.games.machine', 'groups.games.results')->whereIn('status', array('active', 'completed'))->orderBy('date', 'desc')->get()->first();
		}

		foreach($heat->groups as $group) {
			$group->set_points_map(json_decode($season->points_map, true));
			$group->set_group_player_number_on_results();
		}

    return View::make('public.heats.show', array('heat' => $heat, 'heats' => $heats, 'season' => $season));
	}

	public function json_index()
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
