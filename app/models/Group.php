<?php

class Group extends \Eloquent {
  protected $primaryKey = 'group_id';
  protected $softDelete = true;
  protected $fillable = array('code', 'heat_id', 'delta');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at', 'group_id');
  protected $appends = array('name');

  public function players()
  {
      return $this->belongsToMany('Player')->withTimestamps()->orderBy('pivot_created_at');
  }

  public function heat()
  {
      return $this->belongsTo('Heat');
  }

  public function games()
  {
    return $this->hasMany('Game');
  }

  public function getNameAttribute()
  {
    return $this->name();
  }

  public function name() {
    $number = $this->delta+1;
    return "Group {$number}";
  }

  public function url()
  {
    return url('/') . "/#/group/{$this->code}";
  }

}
