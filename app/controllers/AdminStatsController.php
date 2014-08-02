<?php

class AdminStatsController extends \BaseController {

  public function machines()
  {

    $list = DB::table('games')
      ->select(array('machines.name', DB::raw('COUNT(*) as aggregate')))
      ->join('machines', 'games.machine_id', '=', 'machines.machine_id')
      ->groupBy('games.machine_id')
      ->orderBy('aggregate', 'desc')
      ->get();

    return View::make('stats.machines', array('list' => $list));
  }

  public function activities()
  {
    $activities = Activity::take(100)->orderBy('created_at', 'desc')->get();
    return View::make('stats.activities', array('activities' => $activities));
  }

}
