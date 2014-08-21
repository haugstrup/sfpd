<?php

class Group extends \Eloquent {
  protected $primaryKey = 'group_id';
  protected $softDelete = true;
  protected $fillable = array('heat_id', 'delta');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'group_id');
  protected $appends = array('name', 'points');

  public function log($action) {
    Activity::create(array('ref_type' => 'group', 'ref_id' => $this->group_id, 'action' => $action, 'data' => json_encode($this->toArray())));
  }

  public function players()
  {
      return $this->belongsToMany('Player')->withTimestamps()->orderBy('pivot_created_at');
  }

  public function heat()
  {
      return $this->belongsTo('Heat');
  }

  public function games()
  {
    return $this->hasMany('Game');
  }

  public function getNameAttribute()
  {
    return $this->name();
  }

  public function getPointsAttribute()
  {
    return $this->points();
  }

  public function name() {
    $number = $this->delta+1;
    return "Group {$number}";
  }

  public function url()
  {
    return url('/') . "/#/group/{$this->code}";
  }

  public function points()
  {
    $points = array();
    $return = array();

    foreach ($this->games as $game) {
      foreach ($game->results as $result) {
        $points[$result->player_id] = isset($points[$result->player_id]) ? $points[$result->player_id] + $result->points : $result->points;
      }
    }

    foreach ($points as $player_id => $score) {
      $return[] = array(
        'player_id' => $player_id,
        'points' => $score
      );
    }

    return $return;

  }

  public function set_points_map($map)
  {
    $this->points_map = $map;
  }

  public function get_points_map()
  {
    if (!$this->points_map) {
      $raw_map = DB::table('groups')
        ->select(array('seasons.points_map'))
        ->join('heats', 'heats.heat_id', '=', 'groups.heat_id')
        ->join('seasons', 'seasons.season_id', '=', 'heats.season_id')
        ->where('groups.group_id', $this->group_id)
        ->first();

      $this->points_map = json_decode($raw_map->points_map, true);
    }

    return $this->points_map;
  }

  public function set_group_player_number_on_results() {
    foreach ($this->games as $game) {
      foreach ($game->results as $result) {
        $result->player_count = count($this->players);
        $result->has_tardy_player = $game->has_tardy_player();
        $result->set_points_map($this->get_points_map());
      }
    }
  }

}
