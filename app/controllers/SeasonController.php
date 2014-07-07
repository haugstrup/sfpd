<?php

class SeasonController extends \BaseController {

	public function index()
	{
    // Find active season
    $season = Season::with('heats', 'heats.groups', 'players')->where('status', '=', 'active')->orderBy('created_at')->get()->first();
    $season->heats->sortBy('delta');

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
