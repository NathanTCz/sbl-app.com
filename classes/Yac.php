<?php
class Yac {
  public $id;
  public $user_id;
  public $at_risk;
  public $balance;
  public $winnings;
  public $losings; 
  public $updated; 

  public function __construct ($id, $uid, $up, $ar, $b, $w, $l) {
    $this->id = $id;
    $this->user_id = $uid;
    $this->updated = $up; 
    $this->at_risk = sprintf("%01.2f", $ar);
    $this->balance = sprintf("%01.2f", $b);
    $this->winnings = $w; 
    $this->losings = $l;
  }
};
?>
