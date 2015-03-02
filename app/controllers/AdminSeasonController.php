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

    if (Input::get('filter') === 'top5' || Input::get('filter') === 'bottom5') {
      $sorted_points = Season::sorted_points($season->season_id);
      $heats = Input::get('filter') === 'bottom5' ? array_slice($sorted_points['heats'], -5, 5) : array_slice($sorted_points['heats'], 0, 5);

      $summed_points = array();
      foreach ($heats as $heat) {
        if (!empty($heat['points'])) {
          foreach ($heat['points'] as $player_id => $points) {
            if (empty($summed_points[$player_id])) {
              $summed_points[$player_id] = $points['points'];
            } else {
              $summed_points[$player_id] = $summed_points[$player_id] + $points['points'];
            }
          }
        }
      }

      arsort($summed_points);

      $ifpa = array();
      $position = 0;
      $prev_position = 0;
      $current = null;
      foreach ($summed_points as $player_id => $points) {
        $player = $season->players->find($player_id);

        $position++;
        if ($current == $points) {
          $ifpa[] = array(
            'points' => $points,
            'position' => $prev_position,
            'name' => $player->name,
            'ifpa_id' => $player->ifpa_id ? $player->ifpa_id : ''
          );
        } else {
          $ifpa[] = array(
            'points' => $points,
            'position' => $position,
            'name' => $player->name,
            'ifpa_id' => $player->ifpa_id ? $player->ifpa_id : ''
          );
          $prev_position = $position;
        }
        $current = $points;
      }

      $message = 'Showing standings for the '.(Input::get('filter') == 'top5' ? 'first 5 rounds' : 'last 5 rounds').' of the season';

    } else {
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

      $message = 'Showing results for the full season';
    }

    return View::make('seasons.ifpa', array('season' => $season, 'ifpa' => $ifpa, 'message' => $message));
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

  public function validate() {
    $rules = array(
      'name'    => 'required',
      'status' => 'required|in:inactive,active,complete',
      'points_map' => 'required',
      'game_count' => 'required|integer'
    );

    return Validator::make(Input::all(), $rules);

  }

}
