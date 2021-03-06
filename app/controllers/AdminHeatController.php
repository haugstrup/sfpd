<?php

class AdminHeatController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
  }



  public function create()
  {
    return View::make('heats.create', array('heat' => new Heat(array('status' => 'inactive', 'season_id' => Input::get('season_id')))));
  }

  public function store()
  {
    $validator = $this->validate();

    if ($validator->fails())
    {
      return Redirect::route('admin.heats.create', array('season_id' => Input::get('season_id')))->withErrors($validator)->withInput();
    }

    $input = Input::all();
    $season = Season::with('heats')->find($input['season_id']);
    $delta = count($season->heats);
    $date = new \Carbon\Carbon("{$input['html5_date']} {$input['html5_time']}:00", 'America/Los_Angeles');

    $heat = new Heat(array(
      'date' => $date->setTimezone('UTC'),
      'status' => $input['status'],
      'season_id' => $input['season_id'],
      'notes' => empty($input['notes']) ? null : $input['notes'],
      'delta' => $delta
    ));
    $heat->save();

    return Redirect::route('admin.seasons.show', array($season->season_id))->with('success', "Created {$heat->name()} for {$season->name}");
  }

  public function edit($id)
  {
    $heat = Heat::find($id);
    return View::make('heats.edit', array('heat' => $heat));
  }

  public function update($id)
  {

    $validator = $this->validate();

    if ($validator->fails())
    {
      return Redirect::route('admin.heats.edit')->withErrors($validator)->withInput();
    }

    $input = Input::all();
    $heat = Heat::find($id);
    $season = $heat->season;

    // Deactivate all active heats in same season
    if ($input['status'] == 'active') {
      foreach ($season->heats as $current) {
        if ($current->status === 'active') {
          $current->status = 'completed';
          $current->save();
        }
      }
    }

    $date = new \Carbon\Carbon("{$input['html5_date']} {$input['html5_time']}:00", 'America/Los_Angeles');

    $heat->status = $input['status'];
    $heat->date = $date->setTimezone('UTC');
    $heat->notes = empty($input['notes']) ? null : $input['notes'];
    $heat->save();

    return Redirect::route('admin.seasons.show', array($heat->season_id))->with('success', "Updated {$heat->name()} for {$season->name}");
  }

  public function validate()
  {
    $rules = array(
      'html5_date'      => 'required',
      'html5_time'      => 'required',
      'status'    => 'required|in:inactive,active,completed',
      'season_id' => 'required|integer'
    );

    return Validator::make(Input::all(), $rules);
  }


  public function print_groups($id)
  {
    $heat = Heat::with(array('season', 'groups'))->find($id);

    return View::make('heats.print', array('heat' => $heat));
  }

  public function current()
  {
    $season = Season::with('heats')->where('status', '=', 'active')->orderBy('created_at')->get()->first();
    foreach ($season->heats as $heat) {
      if ($heat->status === 'active') {
        return View::make('heats.show', array('heat' => $heat));
        break;
      }
    }

    return Redirect::route('admin.index');
  }

  public function show($id)
  {
    $heat = Heat::with(array('season', 'groups'))->find($id);

    return View::make('heats.show', array('heat' => $heat));
  }

  public function store_groups($id)
  {

    $hashids = new Hashids\Hashids($_ENV['SALT_GROUP'], 4, 'abcdefghijkmnpqrstuvwxyz');

    $count = (int)Input::get('count');
    if ($count > 0 && $count < 30)
    {
      for ($i=1;$i<=$count;$i++) {

        $heat = Heat::with(array('groups'))->find($id);
        $delta = count($heat->groups);

        $group = Group::create(array(
          'heat_id' => $heat->heat_id,
          'delta' => $delta
        ));

        $group->save();

        $group->code = $hashids->encrypt($group->group_id);

        $group->save();

      }

      return Redirect::route('admin.heats.show', $heat->heat_id)->with('success', "Created {$count} new groups for {$heat->name()}");

    }

    $heat = Heat::with(array('groups'))->find($id);
    return Redirect::route('admin.heats.show', $heat->heat_id)->with('error', "Number of groups must be between 1 and 30");

  }

  public function destroy_groups($id)
  {
    $heat = Heat::with(array('groups'))->find($id);

    $kept = 0;
    $deleted = 0;
    foreach ($heat->groups as $group) {
      if (!$group->players || count($group->players) === 0) {
        $deleted++;
        $group->delete();
      }
      else {
        $kept++;
      }
    }

    return Redirect::route('admin.heats.show', $heat->heat_id)->with('success', "Kept {$kept} groups; deleted {$deleted} empty groups");

  }

}
