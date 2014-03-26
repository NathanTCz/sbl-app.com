<?php
class Notification {
  public $title;
  public $desc;
  public $timestamp;
  public $wager_id;

  public function __construct($t, $d, $tm, $w) {
    $this->title = $t;
    $this->desc = $d;
    $this->timestamp = $tm;
    $this->wager_id = $w;
  }
};
?>
