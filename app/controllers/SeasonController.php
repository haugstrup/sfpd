<?php

class SeasonController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(Season::get());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$season = Season::with('players', 'heats')->find($id);
		$season->players->sortBy('display_name');
		return Response::json($season);
	}


}
