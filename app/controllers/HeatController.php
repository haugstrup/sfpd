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
		if ($heat_id) {
			$heat = Heat::with('groups', 'groups.games', 'groups.players', 'groups.games.machine', 'groups.games.results')->find($heat_id);
		}
		else {
			$heat = Heat::with('groups', 'groups.games', 'groups.players', 'groups.games.machine', 'groups.games.results')->whereIn('status', array('active', 'completed'))->orderBy('date', 'desc')->get()->first();
		}

		$season = Season::find($heat->season_id);
		$heats = Heat::whereIn('status', array('active', 'completed'))->where('season_id', '=', $season->season_id)->orderBy('date', 'desc')->get();

		foreach($heat->groups as $group) {
			$group->set_points_map(json_decode($season->points_map, true));
			$group->set_group_player_number_on_results();
		}

    return View::make('public.heats.show', array('heat' => $heat, 'heats' => $heats, 'season' => $season));
	}

}
