<?php

class Machine extends \Eloquent {
  protected $primaryKey = 'machine_id';
  protected $softDelete = true;
  protected $fillable = array('name', 'shortname', 'status');
  protected $hidden = array('created_at', 'deleted_at', 'updated_at');
}
