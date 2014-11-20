<?php

class StatsController extends \BaseController {

  public function index()
  {

    $current_filter = Input::get('filter');
    if ($current_filter) {
      $current_filter = explode(':', $current_filter);
    }

    // $heats = Heat::with('season')->orderBy('season_id', 'desc')->orderBy('delta', 'desc')->get();
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

    $current_filter_name = isset($filter_names[Input::get('filter')]) ? $filter_names[Input::get('filter')] : 'Add filter';

    // Popularity by type
    $type_popular = DB::table('games')
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('machines.type')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.type', 'asc');

    // Popular machines
    $list_popular = DB::table('games')
      ->select(array('machines.name', DB::raw('COUNT(*) as aggregate')))
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.name', 'asc');

    // Apply any filters
    if ($current_filter) {
      $type_popular->join('groups', 'groups.group_id', '=', 'games.group_id');
      $list_popular->join('groups', 'groups.group_id', '=', 'games.group_id');
      if ($current_filter[0] === 'heat') {
        $type_popular->where('groups.heat_id', $current_filter[1]);
        $list_popular->where('groups.heat_id', $current_filter[1]);

        $type_popular->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games INNER JOIN groups ON groups.group_id = games.group_id WHERE groups.heat_id = '.DB::connection()->getPdo()->quote($current_filter[1]).') * 100, 2) AS percentage')));
      }
      elseif ($current_filter[0] === 'season') {
        $type_popular->join('heats', 'heats.heat_id', '=', 'groups.heat_id');
        $type_popular->where('heats.season_id', $current_filter[1]);
        $list_popular->join('heats', 'heats.heat_id', '=', 'groups.heat_id');
        $list_popular->where('heats.season_id', $current_filter[1]);

        $type_popular->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games INNER JOIN groups ON groups.group_id = games.group_id INNER JOIN heats ON heats.heat_id = groups.heat_id WHERE heats.season_id = '.DB::connection()->getPdo()->quote($current_filter[1]).') * 100, 2) AS percentage')));
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
      'filters' => $filters,
      'current_filter_name' => $current_filter_name
    ));
  }

}
