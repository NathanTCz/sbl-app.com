<?php
require_once 'classes/Database.php';

class Notification extends Database {
  public $title;
  public $desc;
  public $timestamp;
  public $wager;

  public function __construct($t, $d, $tm, $w) {
    parent::__construct();

    $this->title = $t;
    $this->desc = $d;
    $this->timestamp = $tm;
    $this->wager = $this->set_wager($w);
  }

  public function set_wager ($wager_id) {
    /*
     * $this->events is inherited from the Database class.
     * cycle through data store to find the event with
     * associated id number
     */
    foreach ($this->wagers as $wager) {
      if ($wager->id == $wager_id) {
        return $wager;
      }
    }
  }
};
?>
