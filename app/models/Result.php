<?php

class Result extends \Eloquent {
  protected $primaryKey = 'result_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'game');
  protected $fillable = array('game_id', 'player_id', 'position', 'delta');
  protected $appends = array('points');
  public $player_count = null;
  public $has_tardy_player = null;

  public function log($action) {
    Activity::create(array('ref_type' => 'result', 'ref_id' => $this->result_id, 'action' => $action, 'data' => json_encode($this->toArray())));
  }

  public function player()
  {
    return $this->belongsTo('Player');
  }

  public function game()
  {
    return $this->belongsTo('Game');
  }

  public function set_points_map($map)
  {
    $this->points_map = $map;
  }

  public function get_points_map()
  {
    if (!$this->points_map) {
      $raw_map = DB::table('games')
        ->select(array('seasons.points_map'))
        ->join('groups', 'groups.group_id', '=', 'games.group_id')
        ->join('heats', 'heats.heat_id', '=', 'groups.heat_id')
        ->join('seasons', 'seasons.season_id', '=', 'heats.season_id')
        ->where('games.game_id', $this->game_id)
        ->first();

      $this->points_map = json_decode($raw_map->points_map, true);
    }

    return $this->points_map;
  }

  public function getPointsAttribute()
  {

    // Result not present always means a zero
    if ($this->position === null) {
      return 0;
    }

    // 0 is D.Q. and always means 1 point
    if ($this->position === 0) {
      return 1;
    }


    $player_count = !is_null($this->player_count) ? $this->player_count : count($this->game->group->players);
    $three_player_group = $player_count === 3 || $this->position < 0 || $this->has_tardy_player;

    $points_map = $this->get_points_map();

    if (!$three_player_group) {
      if (!is_null($this->has_tardy_player)) {
        $three_player_group = $this->has_tardy_player;
      }
      else {
        foreach ($this->game->results as $current) {
          if ($current->position < 0) {
            $three_player_group = true;
            break;
          }
        }
      }
    }

    $size_key = $three_player_group ? 3 : 4;

    $points = 0;
    if (isset($points_map[$size_key]) && isset($points_map[$size_key][$this->position])) {
      $points = $points_map[$size_key][$this->position];
    }

    if ($this->bonus_points) {
      $points = $points+$this->bonus_points;
    }

    return $points;

  }

}
