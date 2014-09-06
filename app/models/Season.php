<?php

class Season extends \Eloquent {
  protected $primaryKey = 'season_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
  protected $fillable = array('name', 'status', 'points_map');

  public $should_adjust_score = false;

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
    $adjusted_points = array();
    $return = array();

    $heat_count = 0;
    foreach ($this->heats as $heat) {
      $heat_points = $heat->points();

      if (count($heat_points) > 0) {
        $heat_count++;
      }

      foreach ($heat_points as $point) {
        $points[$point['player_id']] = isset($points[$point['player_id']]) ? $points[$point['player_id']] + $point['points'] : $point['points'];

        $adjusted_points[$point['player_id']][] = $point['points'];

      }
    }

    // Only calculated adjusted points if season has more than 8 rounds total and more than 5 rounds with groups with games
    $this->should_adjust_score = (count($this->heats) > 8 && $heat_count > 5);

    foreach ($points as $player_id => $score) {

      if ($this->should_adjust_score) {
        rsort($adjusted_points[$player_id]);

        // Remove lowest scores, but keep in mind that a player
        // may not have participated in all rounds
        $heat_diff = $heat_count - count($adjusted_points[$player_id]);
        if ($heat_diff === 0) {
          array_pop($adjusted_points[$player_id]);
          array_pop($adjusted_points[$player_id]);
        } elseif ($heat_diff === 1) {
          array_pop($adjusted_points[$player_id]);
        }

        // Sum up all the things
        $adjusted_points[$player_id] = array_sum($adjusted_points[$player_id]);
      }

      $return[] = array(
        'player_id' => $player_id,
        'points' => $score,
        'adjusted_points' => $this->should_adjust_score ? $adjusted_points[$player_id] : $score,
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
