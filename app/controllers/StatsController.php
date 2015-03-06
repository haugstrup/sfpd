<?php

class StatsController extends \BaseController {

  public function index()
  {

    $filter = $this->prepare_filters();

    // Popularity by type
    $type_popular = DB::table('games')
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('machines.type')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.type', 'asc');

    // Popular machines
    $list_popular = DB::table('games')
      ->select(array('machines.machine_id', 'machines.name', DB::raw('COUNT(*) as aggregate')))
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.name', 'asc');

    // Apply any filters
    if ($filter['current_filter']) {
      $type_popular->join('groups', 'groups.group_id', '=', 'games.group_id');
      $list_popular->join('groups', 'groups.group_id', '=', 'games.group_id');
      if ($filter['current_filter'][0] === 'heat') {
        $type_popular->where('groups.heat_id', $filter['current_filter'][1]);
        $list_popular->where('groups.heat_id', $filter['current_filter'][1]);

        $type_popular->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games INNER JOIN groups ON groups.group_id = games.group_id WHERE groups.heat_id = '.DB::connection()->getPdo()->quote($filter['current_filter'][1]).') * 100, 2) AS percentage')));
      }
      elseif ($filter['current_filter'][0] === 'season') {
        $type_popular->join('heats', 'heats.heat_id', '=', 'groups.heat_id');
        $type_popular->where('heats.season_id', $filter['current_filter'][1]);
        $list_popular->join('heats', 'heats.heat_id', '=', 'groups.heat_id');
        $list_popular->where('heats.season_id', $filter['current_filter'][1]);

        $type_popular->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games INNER JOIN groups ON groups.group_id = games.group_id INNER JOIN heats ON heats.heat_id = groups.heat_id WHERE heats.season_id = '.DB::connection()->getPdo()->quote($filter['current_filter'][1]).') * 100, 2) AS percentage')));
      }
    } else {
      $type_popular->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games) * 100, 2) AS percentage')));
    }


    $type_popular = $type_popular->get();
    $list_popular = $list_popular->get();

    return View::make('public.stats.index', array(
      'list_popular' => $list_popular,
      'type_popular' => $type_popular,
      'type_map' => array('' => 'No type', 'dmd' => 'DMD', 'ss' => 'Solid State', 'em' => 'Electro-Mechanical'),
      'filters' => $filter['filters'],
      'current_filter_name' => $filter['current_filter_name'],
      'raw_filter' => Input::get('filter')
    ));
  }

  public function machine($machine_id) {

    $filter = $this->prepare_filters();

    $machine = Machine::find($machine_id);

    $picks = DB::table('games')
      ->select(array('games.player_id', 'players.display_name', DB::raw('COUNT(*) as count')))
      ->where('games.deleted_at', null)
      ->where('games.machine_id', $machine_id)
      ->join('players', 'games.player_id', '=', 'players.player_id')
      ->groupBy('games.player_id')
      ->orderBy('count', 'desc')
      ->orderBy('players.display_name', 'asc');


    if ($filter['current_filter']) {
      $picks->join('groups', 'groups.group_id', '=', 'games.group_id');
      if ($filter['current_filter'][0] === 'heat') {
        $picks->where('groups.heat_id', $filter['current_filter'][1]);
      }
      elseif ($filter['current_filter'][0] === 'season') {
        $picks->join('heats', 'heats.heat_id', '=', 'groups.heat_id');
        $picks->where('heats.season_id', $filter['current_filter'][1]);
      }
    }

    $picks = $picks->get();

    return View::make('public.stats.machine', array(
      'filters' => $filter['filters'],
      'current_filter_name' => $filter['current_filter_name'],
      'machine' => $machine,
      'picks' => $picks
    ));
  }

  public function players() {

    // Players per round
    $players_per_round = array();
    $heats = Heat::with('season', 'groups', 'groups.players')->orderBy('heats.date', 'asc')->get();
    foreach ($heats as $heat) {
      $key = $heat->season->name.', '.$heat->name();
      $players_per_round[$key] = 0;
      foreach ($heat->groups as $group) {
        $players_per_round[$key] = $players_per_round[$key] + count($group->players);
      }
    }

    // Strength of schedule, oh my
    $players_by_sos = array();
    $season = Season::whereIn('status', array('active', 'complete'))->orderBy('created_at', 'desc')->get()->first();

    if ($season) {
      // Points by player
      $season_id = $season->season_id;
      $points = Season::sorted_points($season_id);
      $points_by_player = array();
      foreach ($points['points'] as $point) {
        $points_by_player[$point['player_id']] = $point['points'];
      }

      // Opponent groups
      $groups = array();
      foreach ($heats as $heat) {
        if ($heat->season_id === $season_id) {
          foreach ($heat->groups as $group) {
            $g = array();
            foreach ($group->players as $player) {
              $g[] = $player->player_id;
            }
            $groups[] = $g;
          }
        }
      }

      // Number of rounds this player has played
      // Opponents faced
      foreach ($points_by_player as $player_id => $current_points) {
        $p = array(
          'total' => 0,
          'opponents_average' => 0,
          'own_average' => 0,
          'rounds' => 0,
          'opponents' => array(),
          'opponents_points' => array(),
          'opponents_averages' => array(),
        );

        foreach ($groups as $group) {
          if (in_array($player_id, $group)) {

            $p['rounds']++;

            foreach ($group as $player) {
              if ($player !== $player_id) {
                $p['opponents'][] = $player;
                $p['opponents_points'][] = $points_by_player[$player];
              }
            }
          }
        }

        $p['total'] = array_sum($p['opponents_points']);
        $p['own_average'] = $points_by_player[$player_id]/$p['rounds'];

        $players_by_sos[$player_id] = $p;

      }

      foreach ($players_by_sos as $player_id => $p) {

        foreach ($p['opponents'] as $opponent) {
          $players_by_sos[$player_id]['opponents_averages'][] = $players_by_sos[$opponent]['own_average'];
        }

        $players_by_sos[$player_id]['opponents_average'] = round(array_sum($players_by_sos[$player_id]['opponents_averages'])/count($players_by_sos[$player_id]['opponents_averages']), 2);

      }

      uasort($players_by_sos, function($a, $b) {
        if ($a['opponents_average'] == $b['opponents_average']) {
          return 0;
        }
        return ($a['opponents_average'] < $b['opponents_average']) ? 1 : -1;
      });
    }

    return View::make('public.stats.players', array(
      'players_per_round' => $players_per_round,
      'players_by_sos' => $players_by_sos,
      'points' => $points
    ));
  }

  public function prepare_filters() {
    $current_filter = Input::get('filter');
    if ($current_filter) {
      $current_filter = explode(':', $current_filter);
    }

    $seasons = Season::with('heats')->orderBy('created_at', 'desc')->get();
    $filters = array('' => 'No filter');
    $filter_names = array();

    foreach ($seasons as $season) {
      $season->heats->sortBy('delta');

      $key = 'season:'.$season->season_id;
      $filters[$key] = "-- ".$season->name." --";
      $filter_names[$key] = $season->name;

      $heats = array();
      foreach ($season->heats as $heat) {
        $key = 'heat:'.$heat->heat_id;
        $heats[$key] = $heat->name;
        $filter_names[$key] = $season->name . ', ' . $heat->name;
      }

      $filters = array_merge($filters, array_reverse($heats));
    }

    return array(
      'current_filter_name' => isset($filter_names[Input::get('filter')]) ? $filter_names[Input::get('filter')] : 'Add filter',
      'filters' => $filters,
      'filter_names' => $filter_names,
      'current_filter' => $current_filter
    );
  }

}
