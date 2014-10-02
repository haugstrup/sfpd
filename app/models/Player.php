<?php

class Player extends Eloquent {
  protected $primaryKey = 'player_id';
  protected $softDelete = true;
  protected $fillable = array('name', 'display_name', 'ifpa_id', 'initials');
  protected $visible = array('player_id', 'display_name', 'legacy_seasons');
  protected $appends = array('formatted_name', 'icon', 'rookie');

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
      return $this->name . ' (R)';
    }
    elseif ($this->pivot && $this->pivot->guest) {
      return $this->name . ' (G)';
    }

    return $this->name;
  }

  public function getRookieAttribute()
  {
    if ($this->pivot && $this->pivot->rookie) {
      return true;
    }
    return false;
  }

  public function getIconAttribute()
  {
    if ($this->pivot && $this->pivot->rookie) {
      return '<span class="player-icon glyphicon glyphicon-tower" title="Rookie"></span>';
    }
    elseif ($this->pivot && $this->pivot->guest) {
      return '<span class="player-icon glyphicon glyphicon-user" title="Guest"></span>';
    }

    return '';
  }

}
