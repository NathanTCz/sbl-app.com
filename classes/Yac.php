<?php
class Yac {
  public $id;
  public $user_id;
  public $at_risk;
  public $balance;

  public function __construct ($id, $uid, $ar, $b) {
    $this->id = $id;
    $this->user_id = $uid;
    $this->at_risk = $ar;
    $this->balance = $b;
  }
};
?>
