<?php
class Wager {
  public $id;
  public $user_id;
  public $amount;
  public $opponent;
  public $event;
  public $outcome;
  public $status;

  public function __construct($id, $uid, $a, $op, $e, $o, $s) {
    $this->id = $id;
    $this->user_id = $uid;
    $this->amount = $a;
    $this->opponent = $op;
    $this->event = $e;
    $this->outcome = $o;
    $this->status = $s;
  }
};