<?php

class AdminActivityController extends \BaseController {

  public function index()
  {
    $activities = Activity::orderBy('created_at', 'desc')->get();
    return View::make('activities.index', array('activities' => $activities));
  }

}
