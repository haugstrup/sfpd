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

  public function getPointsAttribute()
  {

    // Result not present always means a zero
    if ($this->position === null) {
      return 0;
    }

    $player_count = !is_null($this->player_count) ? $this->player_count : count($this->game->group->players);

    $three_player_group = $player_count === 3 || $this->position < 0 || $this->has_tardy_player;

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

    if ($three_player_group) {
      switch ($this->position) {
        case 1:
          return 4.5;
        case 2:
          return 2.5;
        case 3:
        case 0:
          return 1;
        case 4:
        default:
          return 0;
      }
    }
    else {
      switch ($this->position) {
        case 1:
          return 4.5;
        case 2:
          return 3;
        case 3:
          return 2;
        case 4:
        case 0:
          return 1;
        default:
          return 0;
      }
    }

  }

}
