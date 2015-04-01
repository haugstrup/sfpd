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
      ->select(array('games.machine_id', 'machines.name', DB::raw('COUNT(*) as count')))
      ->where('games.deleted_at', null)
      ->where('games.player_id', $player->player_id)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('count', 'desc')
      ->orderBy('machines.name', 'asc')
      ->get();

    $list = DB::table('group_player')
      ->select(array('group_player.group_id'))
      ->where('group_player.player_id', $player->player_id)
      ->get();
    $groups = array();
    foreach ($list as $r) {
      $groups[] = $r->group_id;
    }

    $opponents = DB::table('group_player')
      ->select(array('group_player.player_id', 'players.display_name'))
      ->where('group_player.player_id', '!=', $player->player_id)
      ->whereIn('group_player.group_id', $groups)
      ->join('players', 'group_player.player_id', '=', 'players.player_id')
      ->orderBy('group_player.group_id', 'asc')
      ->get();
    $grudges = array();
    foreach ($opponents as $opponent) {
      if (!isset($grudges[$opponent->player_id])) {
        $grudges[$opponent->player_id] = array('player_id' => $opponent->player_id, 'name' => $opponent->display_name, 'count' => 1);
      } else {
        $grudges[$opponent->player_id]['count'] = $grudges[$opponent->player_id]['count']+1;
      }
    }

    usort($grudges, function($a, $b) {
      if ($a['count'] == $b['count']) {
        return 0;
      }
      return ($a['count'] < $b['count']) ? 1 : -1;
    });

    return View::make('public.players.show', array(
      'player' => $player,
      'seasons' => $seasons,
      'group' => $group,
      'machines' => $machines,
      'grudges' => array_slice($grudges, 0, 10),
    ));
  }

}
