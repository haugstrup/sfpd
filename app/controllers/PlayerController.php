<?php

class PlayerController extends \BaseController {

  public function show($id)
  {
    $player = Player::find($id);
    $seasons = $player->seasons()->orderBy('created_at', 'desc')->get();

    $response = array('player' => $player->toArray());

    // Only load the most recent group, not all groups
    $group = $player->groups()->with('players', 'games', 'games.machine', 'games.results', 'heat', 'heat.season')->orderBy('created_at', 'desc')->first();
    $group->set_group_player_number_on_results();

    // Machines picked
    $machines = DB::table('games')
      ->select(array('machines.name', DB::raw('COUNT(*) as count')))
      ->where('games.deleted_at', null)
      ->where('games.player_id', $player->player_id)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('count', 'desc')
      ->orderBy('machines.name', 'asc')
      ->get();

    $response['group'] = $group->toArray();
    $response['machines'] = $machines;
    $response['seasons'] = $seasons->toArray();

    return Response::json($response);
  }

}
