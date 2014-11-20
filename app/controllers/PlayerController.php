<?php

class PlayerController extends \BaseController {

  public function show($player_id)
  {
    $player = Player::find($player_id);
    $seasons = $player->seasons()->orderBy('created_at', 'desc')->get();
    $group = $player->groups()->with('players', 'games', 'games.machine', 'games.player', 'games.results', 'heat', 'heat.groups', 'heat.season')->orderBy('created_at', 'desc')->first();
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

    return View::make('public.players.show', array('player' => $player, 'seasons' => $seasons, 'group' => $group, 'machines' => $machines));
  }

}
