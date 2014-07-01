<?php

class Heat extends \Eloquent {
  protected $primaryKey = 'heat_id';
  protected $softDelete = true;
  protected $fillable = array('date', 'delta', 'season_id', 'status');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
  protected $appends = array('name', 'formatted_date');

  public function getDates()
  {
      return array('created_at', 'updated_at', 'date');
  }

  public function season()
  {
      return $this->belongsTo('Season', 'season_id', 'season_id');
  }

  public function groups()
  {
    return $this->hasMany('Group');
  }

  public function getNameAttribute()
  {
    return $this->name();
  }

  public function getFormattedDateAttribute()
  {
    return $this->name();
  }

  public function formatted_date() {
    return $this->date->setTimezone(new DateTimeZone('America/Los_Angeles'))->format('l, F jS, g:iA');
  }

  public function name() {
    $number = $this->delta+1;
    return "Round {$number}";
  }

  public function full_name() {
    return "{$this->name()}: {$this->formatted_date()}";
  }

}
