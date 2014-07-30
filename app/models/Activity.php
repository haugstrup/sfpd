<?php

class Activity extends \Eloquent {
  protected $primaryKey = 'activity_id';
  protected $softDelete = true;
  protected $fillable = array('ref_type', 'ref_id', 'action', 'data');

  public function actionFormatted() {
    $data = $this->dataDecoded();
    switch ($this->action) {
      case 'players_update':
        return 'Updating players';
        break;
      case 'create':
        return 'Creating '.ucfirst($this->ref_type);
        break;
      case 'update':
        return 'Updating '.ucfirst($this->ref_type);
        break;
      case 'destroy':
        return 'Destroying '.ucfirst($this->ref_type);
        break;
      default:
        return '';
        break;
    }
  }

  public function dataDecoded() {
    return json_decode($this->data);
  }

}
