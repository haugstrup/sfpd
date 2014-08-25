<?php

class AdminGroupController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }

  public function show($id)
  {
    $group = Group::with(array('players', 'heat', 'heat.season', 'games', 'games.results', 'games.machine'))->find($id);

    return View::make('groups.show', array('group' => $group));
  }

  public function edit($id)
  {
    $group = Group::with(array('players', 'heat', 'heat.season', 'heat.season.players', 'games', 'games.results', 'games.machine'))->find($id);
    $group->heat->season->players->sortBy('name');

    $machines = Machine::orderBy('name')->get();
    $machines_options = array('' => '-- no machine --');
    foreach ($machines as $machine) {
      $machines_options[$machine->machine_id] = $machine->name;
    }

    $players = array('' => '-- no player --');
    foreach ($group->heat->season->players as $player) {
      $players[$player->player_id] = $player->name;
    }

    return View::make('groups.edit', array(
      'group' => $group,
      'players' => $players,
      'machines' => $machines_options,
      'points_map' => json_decode($group->heat->season->points_map, true)
    ));
  }

  public function update_players($id)
  {
    $group = Group::with(array('players'))->find($id);

    $player_ids = array();
    foreach (Input::get('players') as $raw_id) {
      if ($raw_id) {
        $player_ids[] = (int)$raw_id;
      }
    }

    $group->players()->sync($player_ids);
    $group->save();

    return Redirect::route('admin.groups.edit', array($group->group_id))->with('success', "Updated players on {$group->name}");
  }

  public function update_results($id)
  {
    $hashids = new Hashids\Hashids($_ENV['SALT_GAME'], 9, 'abcdefghijkmnpqrstuvwxyz');
    $input = Input::all();

    // Get group
    $group = Group::with(array('players'))->find($id);

    for($i=0;$i<4;$i++) {
      if (!empty($input['machines'][$i])) {
        // Create game
        $game = new Game(array(
          'group_id' => $group->group_id,
          'machine_id' => (int)$input['machines'][$i],
          'player_id' => null,
          'status' => 'completed'
        ));
        $game->save();

        $game->code = $hashids->encrypt($game->game_id);

        $game->save();

        // Loop over each result and create it
        foreach ($group->players as $player) {
          if (isset($input['results'][$i]) && isset($input['results'][$i][$player->player_id])) {
            $position = null;
            if ($input['results'][$i][$player->player_id] === "0") {
              $position = 0;
            } elseif ($input['results'][$i][$player->player_id]) {
              $position = (int)$input['results'][$i][$player->player_id];
            }

            $result = new Result(array(
              'game_id' => $game->game_id,
              'player_id' => $player->player_id,
              'delta' => null,
              'position' => $position,
              'bonus_points' => isset($input['bonus'][$i]) && !empty($input['bonus'][$i][$player->player_id]) ? 1 : null
            ));
            $result->save();

          }
        }
      }

    }

    // Redirect
    return Redirect::route('admin.groups.show', array($group->group_id))->with('success', "Updated results on {$group->name}");

  }

}
