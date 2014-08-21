<?php

class Season extends \Eloquent {
  protected $primaryKey = 'season_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
  protected $fillable = array('name', 'status', 'points_map');

  public function heats()
  {
    return $this->hasMany('Heat');
  }

  public function players()
  {
      return $this->belongsToMany('Player')->withPivot('rookie', 'guest', 'final_position');
  }

  public function is_rookie($player)
  {
    foreach ($this->players as $current) {
      if ($current->player_id === $player->player_id) {
        return $current->pivot->rookie;
      }
    }
    return false;
  }

  public function is_guest($player)
  {
    foreach ($this->players as $current) {
      if ($current->player_id === $player->player_id) {
        return $current->pivot->guest;
      }
    }
    return false;
  }

  public function has_player($player)
  {
    foreach ($this->players as $current) {
      if ($current->player_id === $player->player_id) {
        return true;
      }
    }
    return false;
  }

  public function points() {
    $points = array();
    $return = array();

    foreach ($this->heats as $heat) {
      foreach ($heat->points() as $point) {
        $points[$point['player_id']] = isset($points[$point['player_id']]) ? $points[$point['player_id']] + $point['points'] : $point['points'];
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

  public function set_group_player_number_on_results() {
    foreach ($this->heats as $heat) {
      foreach ($heat->groups as $group) {
        $group->set_points_map(json_decode($this->points_map, true));
        $group->set_group_player_number_on_results();
      }
    }
  }

}
