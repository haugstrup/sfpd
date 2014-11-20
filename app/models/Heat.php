<?php

class Heat extends \Eloquent {
  protected $primaryKey = 'heat_id';
  protected $softDelete = true;
  protected $fillable = array('date', 'delta', 'season_id', 'status');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
  protected $appends = array('name', 'formatted_date', 'full_name', 'short_name');

  public function getDates()
  {
      return array('created_at', 'updated_at', 'date');
  }

  public function season()
  {
      return $this->belongsTo('Season', 'season_id', 'season_id');
  }

  public function groups()
  {
    return $this->hasMany('Group');
  }

  public function getShortNameAttribute()
  {
    $number = $this->delta+1;
    return "Rd {$number}";
  }

  public function getNameAttribute()
  {
    return $this->name();
  }

  public function getFormattedDateAttribute()
  {
    return $this->formatted_date();
  }

  public function getFullNameAttribute()
  {
    return $this->full_name();
  }

  public function formatted_date() {
    return $this->date->setTimezone(new DateTimeZone('America/Los_Angeles'))->format('l, F jS, g:iA');
  }

  public function name() {
    $number = $this->delta+1;
    return "Round {$number}";
  }

  public function full_name() {
    return "{$this->name()}: {$this->formatted_date()}";
  }

  public function points() {
    $points = array();
    $return = array();
    $player_group = array();

    foreach ($this->groups as $group) {
      foreach ($group->points as $point) {
        $points[$point['player_id']] = isset($points[$point['player_id']]) ? $points[$point['player_id']] + $point['points'] : $point['points'];

        $player_group[$point['player_id']] = $group->group_id;
      }
    }

    foreach ($points as $player_id => $score) {
      $return[] = array(
        'player_id' => $player_id,
        'points' => $score,
        'group_id' => $player_group[$player_id]
      );
    }

    return $return;
  }

  public function player_count()
  {
    $count = 0;

    foreach ($this->groups as $group) {
      $count = $count + count($group->players);
    }

    return $count;
  }

  public function game_stats()
  {
    static $return;

    if ($return && $return['first'] && $return['last']) {
      return $return;
    }

    $return = array(
      'first' => null,
      'last' => null
    );

    foreach ($this->groups as $group) {
      foreach ($group->games as $game) {
        if ($game->created_at < $return['first'] || $return['first'] === null) {
          $return['first'] = $game->created_at->copy()->tz('America/Los_Angeles');
        }
        if ($game->updated_at > $return['last'] || $return['last'] === null) {
          $return['last'] = $game->updated_at->copy()->tz('America/Los_Angeles');
        }
      }
    }

    // Calculate timespan for timeline
    if ($return['first'] && $return['last']) {
      $return['diff'] = $return['first']->diffInMinutes($return['last']);
    }

    return $return;
  }

}
