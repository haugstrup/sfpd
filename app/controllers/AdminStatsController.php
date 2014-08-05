<?php

class AdminStatsController extends \BaseController {

  public function machines()
  {

    // Popularity by type
    $type_popular = DB::table('games')
      ->select(array('machines.type', DB::raw('COUNT(*) as aggregate'), DB::raw('ROUND(COUNT(*) / (SELECT COUNT(*) FROM games) * 100, 2) AS percentage')))
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('machines.type')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.type', 'asc')
      ->get();

    // Popular machines
    $list_popular = DB::table('games')
      ->select(array('machines.name', DB::raw('COUNT(*) as aggregate')))
      ->where('games.deleted_at', null)
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('aggregate', 'desc')
      ->orderBy('machines.name', 'asc')
      ->get();

    return View::make('stats.machines', array(
      'list_popular' => $list_popular,
      'type_popular' => $type_popular,
      'type_map' => array('' => 'No type', 'dmd' => 'DMD', 'ss' => 'Solid State', 'em' => 'Electro-Mechanical')
    ));
  }

  public function activities()
  {
    $activities = Activity::take(100)->orderBy('created_at', 'desc')->get();
    return View::make('stats.activities', array('activities' => $activities));
  }

}
