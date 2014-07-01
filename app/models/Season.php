<?php

class Season extends \Eloquent {
  protected $primaryKey = 'season_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');

  public function heats()
  {
    return $this->hasMany('Heat');
  }

  public function players()
  {
      return $this->belongsToMany('Player');
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

}
