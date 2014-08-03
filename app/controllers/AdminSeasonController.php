<?php

class AdminSeasonController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }

  public function players($season_id)
  {
    $season = Season::find($season_id);
    $players = Player::orderBy('name')->get();

    return View::make('seasons.players', array('season' => $season, 'players' => $players));
  }

  public function update_players($season_id) {
    $season = Season::with('players')->find($season_id);

    $players = array();
    foreach (Input::get('players') as $player_id) {
      $players[] = (int)$player_id;
    }

    $season->players()->sync($players);
    $season->save();


    // Update pivot table values for rookies and guests
    $rookies = array();
    if (is_array(Input::get('rookies'))) {
      foreach (Input::get('rookies') as $player_id) {
        $rookies[] = (int)$player_id;
      }
      DB::table('player_season')
        ->where('season_id', $season->season_id)
        ->update(array('rookie' => false));
      DB::table('player_season')
        ->where('season_id', $season->season_id)
        ->whereIn('player_id', $rookies)
        ->update(array('rookie' => true));
    }

    $guests = array();
    if (is_array(Input::get('guests'))) {
      foreach (Input::get('guests') as $player_id) {
        $guests[] = (int)$player_id;
      }
      DB::table('player_season')
        ->where('season_id', $season->season_id)
        ->update(array('guest' => false));
      DB::table('player_season')
        ->where('season_id', $season->season_id)
        ->whereIn('player_id', $guests)
        ->update(array('guest' => true));
    }

    return Redirect::route('admin.index')->with('success', "Updated players for {$season->name}");
  }

  public function store_heat($id)
  {
    $rules = array(
      'date'    => 'required',
      'time'    => 'required'
    );

    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails())
    {
      return Redirect::route('admin.index')->withErrors($validator)->withInput();
    }

    $input = Input::all();
    $season = Season::with('heats')->find($id);
    $delta = count($season->heats);
    $date = new \Carbon\Carbon("{$input['date']} {$input['time']}:00", 'America/Los_Angeles');

    $heat = new Heat(array(
      'date' => $date->setTimezone('UTC'),
      'status' => 'inactive',
      'season_id' => $id,
      'delta' => $delta
    ));
    $heat->save();

    return Redirect::route('admin.index')->with('success', "Created {$heat->name()} for {$season->name}");

  }

}
