<?php

class Game extends \Eloquent {
  protected $primaryKey = 'game_id';
  protected $softDelete = true;
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'game_id');
  protected $fillable = array('status', 'player_id', 'group_id', 'machine_id');

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

}
