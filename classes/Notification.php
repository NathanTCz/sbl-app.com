<?php
class Notification {
  public $title;
  public $desc;
  public $timestamp;

  public function __construct($t, $d, $tm) {
    $this->title = $t;
    $this->desc = $d;
    $this->timestamp = $tm;
  }
};
?>
