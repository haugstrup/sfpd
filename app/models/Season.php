<?php

class Season extends \Eloquent {
  protected $primaryKey = 'season_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
  protected $fillable = array('name', 'status', 'points_map', 'game_count', 'adjust_points');

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

  public function final_position($player) {
    foreach ($this->players as $current) {
      if ($current->player_id === $player->player_id) {
        return $current->pivot->final_position;
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

  public function should_adjust_score()
  {
    // Only calculated adjusted points if:
    //  * adjust_points property is set
    //  * Heat number `adjust_points` (index == `adjust_points`-1) has a game with results
    $index = $this->adjust_points ? ($this->adjust_points-1) : 0;
    if (
      $this->adjust_points && $this->adjust_points > 0 &&
      isset($this->heats[$index]) &&
      count($this->heats[$index]->groups) > 0 &&
      count($this->heats[$index]->groups[0]->games) > 0 &&
      count($this->heats[$index]->groups[0]->games[0]->results) > 0
    ) {
      return true;
    }
    return false;
  }

  public function points($sort = false) {
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

    $should_adjust_score = $this->should_adjust_score();

    foreach ($points as $player_id => $score) {

      if ($should_adjust_score) {
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
        'adjusted_points' => $should_adjust_score ? $adjusted_points[$player_id] : $score,
      );
    }

    if ($sort) {
      function points_sort($a, $b) {
        return $a['adjusted_points'] == $b['adjusted_points'] ? 0 : ($a['adjusted_points'] > $b['adjusted_points']) ? -1 : 1;
      }
      usort($return, 'points_sort');
    }

    return $return;
  }

  public function get_player_by_id($player_id)
  {
    foreach ($this->players as $player) {
      if ($player->player_id === $player_id) {
        return $player;
      }
    }
    return null;
  }

  public function set_group_player_number_on_results() {
    foreach ($this->heats as $heat) {
      foreach ($heat->groups as $group) {
        $group->set_points_map(json_decode($this->points_map, true));
        $group->set_group_player_number_on_results();
      }
    }
  }


  // TODO: This really shouldn't be a static function
  public static function sorted_points($season_id = null, $filter = null)
  {
    $season = null;

    if (!$season_id) {
      $season = Season::whereIn('status', array('active', 'complete'))->orderBy('created_at', 'desc')->get()->first();
      $season_id = $season->season_id;
    }

    if (Cache::has('season-points-'.$season_id)) {
      if (!$season) {
        $season = Season::find($season_id);
      }

      $response = $season->toArray();
      $response['players'] = Cache::get('season-players-'.$season_id);
      $response['heats'] = Cache::get('season-heats-'.$season_id);
      $response['points'] = Cache::get('season-points-'.$season_id);
      $response['should_adjust_score'] = Cache::get('season-adjust-score-'.$season_id);

    } else {
      $season = Season::with('players', 'heats', 'heats.groups', 'heats.groups.players', 'heats.groups.games', 'heats.groups.games.results')->find($season_id);

      $season->heats->sortBy('delta');

      $season->set_group_player_number_on_results();

      // Return it with players, heats and points
      $response = $season->toArray();

      // Remove "groups" from "heats" to keep payload small
      foreach ($response['heats'] as $index => $heat) {
        unset($response['heats'][$index]['groups']);
        $h = $season->heats->find($heat['heat_id']);
        $response['heats'][$index]['points'] = $h->points();
      }

      $response['points'] = $season->points();
      $response['should_adjust_score'] = $season->should_adjust_score();

      Cache::forever('season-players-'.$season_id, $response['players']);
      Cache::forever('season-heats-'.$season_id, $response['heats']);
      Cache::forever('season-points-'.$season_id, $response['points']);
      Cache::forever('season-adjust-score-'.$season_id, $response['should_adjust_score']);

    }


    $response['has_final_position'] = false;
    if (!empty($response['players'])) {
      $some_player = current($response['players']);
      if (isset($some_player['final_position'])) {
        $response['has_final_position'] = true;
      }
    }

    // Sort points.
    if ($response['should_adjust_score']) {
      usort($response['points'], function($a, $b) {
        if ($a['adjusted_points'] == $b['adjusted_points']) {
          if ($a['points'] == $b['points']) {
            return 0;
          }
          return ($a['points'] < $b['points']) ? 1 : -1;
        }
        return ($a['adjusted_points'] < $b['adjusted_points']) ? 1 : -1;
      });
    }
    else {
      usort($response['points'], function($a, $b) {
        if ($a['points'] == $b['points']) {
          return 0;
        }
        return ($a['points'] < $b['points']) ? 1 : -1;
      });
    }

    // Set positions on points
    $position = null;
    $position_points = null;
    $count = 0;
    foreach ($response['points'] as $index => $value) {
      $points = $response['should_adjust_score'] ? $value['adjusted_points'] : $value['points'];
      $count++;
      if ($position_points === $points) {
        $response['points'][$index]['position'] = ' ';
      }
      else {
        $position = $index;
        $position_points = $points;
        $response['points'][$index]['position'] = $count;
      }
    }

    // Key players by player_id
    $players = array();
    if (is_array($response['players'])) {
      foreach ($response['players'] as $player) {
        $players[$player['player_id']] = $player;
      }
    }
    $response['players'] = $players;

    // Key heat points by player_id
    foreach ($response['heats'] as $index => $heat) {
      $points = array();
      foreach ($heat['points'] as $point) {
        $points[$point['player_id']] = array('points' => $point['points'], 'group_id' => $point['group_id']);
      }
      $response['heats'][$index]['points'] = $points;
    }

    return $response;
  }

}
