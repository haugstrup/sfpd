<?php

class AdminHeatController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('csrf', array('on' => array('post', 'put', 'delete')));
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

  public function activate($id)
  {
    $heat = Heat::find($id);

    // Deactivate all active heats in same season
    $season = $heat->season;
    foreach ($season->heats as $current) {
      if ($current->status === 'active') {
        $current->status = 'inactive';
        $current->save();
      }
    }

    $heat->status = 'active';
    $heat->save();

    return Redirect::route('admin.index')->with('success', "{$heat->name()} activated");
  }

  public function deactivate($id)
  {
    $heat = Heat::find($id);
    $heat->status = 'inactive';
    $heat->save();

    return Redirect::route('admin.index')->with('success', "{$heat->name()} closed");
  }


}
