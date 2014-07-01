<?php

class AdminPlayerController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }

  public function index()
  {
    $players = Player::orderBy('display_name')->get();
    return View::make('players.index', array('players' => $players));
  }

  public function create()
  {
    return View::make('players.create', array('player' => new Player()));
  }

  public function store()
  {
    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.players.create')->withErrors($validator)->withInput();
    }

    $player = new Player(Input::all());
    $player->save();

    return Redirect::route('admin.players.index')->with('success', "Created {$player->name}");
  }

  public function edit($id)
  {
    $player = Player::find($id);
    return View::make('players.edit', array('player' => $player));
  }

  public function update($id)
  {

    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.players.edit', $id)->withErrors($validator)->withInput();
    }

    $player = Player::find($id);
    $player->fill(Input::all());
    $player->save();

    return Redirect::route('admin.players.index')->with('success', "{$player->name} updated");
  }

  public function validate() {
    $rules = array(
      'name'    => 'required',
      'display_name'    => 'required',
      'ifpa_id' => 'integer'
    );

    return Validator::make(Input::all(), $rules);

  }

}
