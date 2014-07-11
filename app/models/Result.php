<?php

class Result extends \Eloquent {
  protected $primaryKey = 'result_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'game');
  protected $fillable = array('game_id', 'player_id', 'position', 'delta');
  protected $appends = array('points');

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

    $three_player_group = count($this->game->group->players) === 3 || $this->position < 0;

    // If at least one player is tardy, score as three person group
    if (!$three_player_group) {
      foreach ($this->game->results as $current) {
        if ($current->position < 0) {
          $three_player_group = true;
          break;
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
          return 1;
        default:
          return 0;
      }
    }

  }

}
