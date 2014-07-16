<?php

class Activity extends \Eloquent {
  protected $primaryKey = 'activity_id';
  protected $softDelete = true;
  protected $fillable = array('ref_type', 'ref_id', 'action', 'data');

}
