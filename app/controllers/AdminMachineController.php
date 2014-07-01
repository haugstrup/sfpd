<?php

class AdminMachineController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }

  public function index()
  {
    $machines = Machine::orderBy('name')->get();
    return View::make('machines.index', array('machines' => $machines));
  }

  public function create()
  {
    return View::make('machines.create', array('machine' => new Machine()));
  }

  public function store()
  {
    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.machines.create')->withErrors($validator)->withInput();
    }

    $machine = new Machine(Input::all());
    $machine->save();

    return Redirect::route('admin.machines.index')->with('success', "Created {$machine->name}");
  }

  public function edit($id)
  {
    $machine = Machine::find($id);
    return View::make('machines.edit', array('machine' => $machine));
  }

  public function update($id)
  {

    $validator = $this->validate();
    if ($validator->fails())
    {
      return Redirect::route('admin.machines.edit', $id)->withErrors($validator)->withInput();
    }

    $machine = Machine::find($id);
    $machine->fill(Input::all());
    $machine->save();

    return Redirect::route('admin.machines.index')->with('success', "{$machine->name} updated");
  }

  public function activate($id)
  {
    $machine = Machine::find($id);
    $machine->status = 'active';
    $machine->save();

    return Redirect::route('admin.machines.index')->with('success', "{$machine->name} activated");
  }

  public function deactivate($id)
  {
    $machine = Machine::find($id);
    $machine->status = 'inactive';
    $machine->save();

    return Redirect::route('admin.machines.index')->with('success', "{$machine->name} deactivated");
  }

  public function validate() {
    $rules = array(
      'name'    => 'required',
      'status' => 'required|in:active,inactive'
    );

    return Validator::make(Input::all(), $rules);

  }

}
