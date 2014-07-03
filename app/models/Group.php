<?php

class Group extends \Eloquent {
  protected $primaryKey = 'group_id';
  protected $softDelete = true;
  protected $fillable = array('heat_id', 'delta');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'group_id');
  protected $appends = array('name', 'points');

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

}
