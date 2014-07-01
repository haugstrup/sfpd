<?php

class GameController extends \BaseController {

	public function show($id)
	{
		$game = Game::with('player', 'machine', 'group.players', 'results', 'results.player')->find($id);

		if (!$game || $game->group->heat->status != 'active') {
			App::abort(404);
		}

		return Response::json($game);
	}

	public function update($id)
	{
		$game = Game::with('results')->find($id);

		if (!$game || $game->status != 'active') {
			App::abort(403);
		}

		foreach (Input::get('results') as $current) {
			$result = $game->results->find((int)$current['result_id']);
			if ($result) {
				$result->position = (int)$current['position'];
				$result->save();
			}
		}

		$game->status = Input::get('status');
		$game->save();

	}


}
