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

}
