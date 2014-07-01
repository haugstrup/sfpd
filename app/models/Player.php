<?php

class Player extends Eloquent {
  protected $primaryKey = 'player_id';
  protected $softDelete = true;
  protected $fillable = array('name', 'display_name', 'ifpa_id', 'initials');
  protected $visible = array('player_id', 'display_name');

  public function seasons()
  {
      return $this->belongsToMany('Season');
  }

  public function groups()
  {
      return $this->belongsToMany('Group');
  }

}
