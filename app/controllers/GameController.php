<?php

class GameController extends \BaseController {

	public function show($code)
	{
		$game = Game::with('player', 'machine', 'group.players', 'results', 'results.player')->where('code', '=', $code)->get()->first();

		if (!$game || $game->group->heat->status != 'active') {
			App::abort(404);
		}

		return Response::json($game);
	}

	public function update($code)
	{
		$game = Game::with('results')->where('code', '=', $code)->get()->first();

		if (!$game || $game->group->heat->status != 'active') {
			App::abort(403);
		}

		foreach (Input::get('results') as $current) {
			$result = $game->results->find((int)$current['result_id']);
			if ($result) {
				$result->position = is_null($current['position']) ? null : (int)$current['position'];
				$result->save();

				$result->log('update');
			}
		}

		$game->status = Input::get('status');
		$game->save();

		$game->log('update');

	}

	public function destroy($code)
	{
		$game = Game::with('group.heat', 'results')->where('code', '=', $code)->get()->first();

		if (!$game || $game->group->heat->status != 'active') {
			App::abort(404);
		}

		$canDelete = true;
		foreach ($game->results as $result) {
			if ($result->position != null) {
				$canDelete = false;
			}
		}

		if (!$canDelete) {
			App::abort(403);
		}

		$game->log('destroy');

		$game->results()->delete();
		$game->delete();

		return Response::make('',204);
	}


}
