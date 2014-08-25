<?php

class Game extends \Eloquent {
  protected $primaryKey = 'game_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'game_id');
  protected $fillable = array('status', 'player_id', 'group_id', 'machine_id');

  public function getDates()
  {
      return array('created_at', 'updated_at');
  }

  public function log($action) {
    Activity::create(array('ref_type' => 'game', 'ref_id' => $this->game_id, 'action' => $action, 'data' => json_encode($this->toArray())));
  }

  public function results()
  {
    return $this->hasMany('Result');
  }

  public function machine()
  {
    return $this->belongsTo('Machine');
  }

  public function player()
  {
    return $this->belongsTo('Player');
  }

  public function group()
  {
      return $this->belongsTo('Group');
  }

  public function local_created_at()
  {
    return $this->created_at->copy()->tz('America/Los_Angeles');
  }

  public function local_updated_at()
  {
    return $this->updated_at->copy()->tz('America/Los_Angeles');
  }

  public function result_for_player($player)
  {
    foreach ($this->results as $result) {
      if ($result->player_id === $player->player_id) {
        return $result;
      }
    }
  }

  public function has_tardy_player() {
    foreach ($this->results as $current) {
      if ($current->position < 0) {
        return true;
      }
    }
    return false;
  }

}
