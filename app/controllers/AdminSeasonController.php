<?php

class AdminSeasonController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }

  public function show($id)
  {
    $season = Season::find($id);
    $season->heats->sortBy('delta');

    return View::make('seasons.show', array('season' => $season));
  }

  public function index()
  {
    $seasons = Season::orderBy('created_at', 'desc')->get();
    return View::make('seasons.index', array('seasons' => $seasons));
  }

  public function create()
  {
    return View::make('seasons.create', array('season' => new Season()));
  }

  public function store()
  {
    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.seasons.create')->withErrors($validator)->withInput();
    }

    $season = new Season(Input::all());
    $season->save();

    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "Created {$season->name}");
  }

  public function edit($id)
  {
    $season = Season::find($id);
    return View::make('seasons.edit', array('season' => $season));
  }

  public function update($id)
  {

    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.seasons.edit', $id)->withErrors($validator)->withInput();
    }

    $season = Season::find($id);
    $season->fill(Input::all());
    $season->save();

    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "{$season->name} updated");
  }

  public function ifpa($season_id)
  {
    $season = Season::with('players')->find($season_id);
    $ifpa = array();
    foreach ($season->players as $player) {
      if ($player->pivot->final_position) {
        $ifpa[] = array(
          'position' => $player->pivot->final_position,
          'name' => $player->name,
          'ifpa_id' => $player->ifpa_id ? $player->ifpa_id : ''
        );
      }
    }

    usort($ifpa, function($a, $b) {
      return $a['position'] == $b['position'] ? 0 : ($a['position'] > $b['position']) ? 1 : -1;
    });

    return View::make('seasons.ifpa', array('season' => $season, 'ifpa' => $ifpa));
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

    Cache::forget('season-players-'.$season->season_id);

    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "Updated players for {$season->name}");
  }

  public function positions($season_id)
  {
    $season = Season::with('players', 'heats', 'heats.groups', 'heats.groups.players', 'heats.groups.games', 'heats.groups.games.results')->find($season_id);
    $season->set_group_player_number_on_results();
    $points = $season->points(true);

    $position_points = null;
    $position = null;
    foreach ($points as $index => $point) {
      $adjusted_index = $index+1;
      if ($position_points === $point['adjusted_points']) {
        $points[$index]['position'] = $position;
      } else {
        $position = $adjusted_index;
        $position_points = $point['adjusted_points'];
        $points[$index]['position'] = $position;
      }
    }

    return View::make('seasons.positions', array('season' => $season, 'points' => $points));
  }

  public function update_positions($season_id)
  {
    $season = Season::find($season_id);
    foreach (Input::get('players') as $player_id => $position) {
      DB::table('player_season')
        ->where('season_id', $season->season_id)
        ->where('player_id', (int)$player_id)
        ->update(array('final_position' => (int)$position));
    }
    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "Final positions updated for {$season->name}");
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

    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "Created {$heat->name()} for {$season->name}");

  }

  public function validate() {
    $rules = array(
      'name'    => 'required',
      'status' => 'required|in:active,complete',
      'points_map' => 'required'
    );

    return Validator::make(Input::all(), $rules);

  }

}
