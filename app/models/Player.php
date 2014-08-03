<?php

class Player extends Eloquent {
  protected $primaryKey = 'player_id';
  protected $softDelete = true;
  protected $fillable = array('name', 'display_name', 'ifpa_id', 'initials');
  protected $visible = array('player_id', 'display_name');
  protected $appends = array('formatted_name');

  public function seasons()
  {
    return $this->belongsToMany('Season')->withPivot('rookie', 'guest', 'final_position');
  }

  public function groups()
  {
    return $this->belongsToMany('Group');
  }

  public function getFormattedNameAttribute()
  {
    if ($this->pivot && $this->pivot->rookie) {
      return $this->display_name . ' (R)';
    }
    elseif ($this->pivot && $this->pivot->guest) {
      return $this->display_name . ' (G)';
    }

    return $this->display_name;
  }

}
