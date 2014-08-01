<?php

class AdminActivityController extends \BaseController {

  public function index()
  {
    $activities = Activity::take(100)->orderBy('created_at', 'desc')->get();
    return View::make('activities.index', array('activities' => $activities));
  }

}
