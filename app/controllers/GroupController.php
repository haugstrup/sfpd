<?php

class GroupController extends \BaseController {

	public function show($code)
	{
		return $this->respond_with_full_group($code);
	}

	public function update($code)
	{
		$group = Group::with('players', 'games', 'heat')->where('code', '=', $code)->get()->first();
		$season = Season::with('players')->find($group->heat->season_id);
		$machines = Machine::orderBy('name')->where('status', '=', 'active')->get();

		// Only update players if there are no games
		if (count($group->games) === 0) {
			$players = array();
			foreach (Input::get('players') as $player_input) {
				$players[] = $player_input['player_id'];
			}

			$group->players()->sync($players);
			$group->save();

			$group->log('players_update');

		}

		return $this->respond_with_full_group($code);
	}

	public function store_game($code)
	{
		$group = Group::with('players', 'games', 'heat')->where('code', '=', $code)->get()->first();
		$player = Input::get('player');
		$machine = Input::get('machine');
		$machine = Machine::find((int)$machine['machine_id']);

		if (!$group || $group->heat->status != 'active') {
			App::abort(404);
		}

		// Make sure player picking game is in group
		if (!$group->players->contains((int)$player['player_id'])) {
			App::abort(403);
		}

		// Make sure not to create more than 4 games
		if (count($group->games) >= 4) {
			App::abort(403);
		}

		// Make sure machine is active
		if ($machine->status != 'active') {
			App::abort(403);
		}

		// Create game

    $hashids = new Hashids\Hashids($_ENV['SALT_GAME'], 9, 'abcdefghijkmnpqrstuvwxyz');

		$input = Input::all();
		$game = new Game(array(
			'group_id' => $group->group_id,
			'machine_id' => (int)$input['machine']['machine_id'],
			'player_id' => (int)$input['player']['player_id'],
			'status' => $input['status']
		));
		$game->save();

    $game->code = $hashids->encrypt($game->game_id);

    $game->save();

		$game->log('create');

		// Players in order according to group_player pivot timestamp
		// Starting with person picking as player one
		$before_order = array();
		$after_order = array();
		$has_handled_player_one = false;
		foreach ($group->players as $current) {
			if ($current->player_id === (int)$player['player_id']) {
				array_unshift($after_order, $current->player_id);
				$has_handled_player_one = true;
			}
			else if ($has_handled_player_one) {
				array_push($after_order, $current->player_id);
			}
			else {
				array_push($before_order, $current->player_id);
			}
		}

		$order = array_merge($after_order, $before_order);

		foreach ($order as $index => $player_id) {
			$result = new Result(array(
				'game_id' => $game->game_id,
				'player_id' => $player_id,
				'delta' => $index
			));
			$result->save();

			$result->log('create');

		}

		// Send group back so we're sure to get all games
		return $this->respond_with_full_group($code);

	}

	public function respond_with_full_group($code)
	{

		$group = Group::with('players', 'games.machine', 'games.player', 'games.results', 'heat')->where('code', '=', $code)->get()->first();

		if (!$group || $group->heat->status != 'active') {
			App::abort(404);
		}

		$season = Season::with('players')->find($group->heat->season_id);
		$machines = Machine::orderBy('name')->where('status', '=', 'active')->get();

		$response = $group->toArray();
		$response['season'] = $season->toArray();
		$response['machines'] = $machines->toArray();

		return Response::json($response);

	}

}
