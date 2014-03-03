<?php
require_once 'classes/Database.php';
require_once 'classes/Event.php';

class Wager extends Database {
  public $id;
  public $user_id;
  public $amount;
  public $opponent_id;
  private $event;
  public $outcome;
  public $status;
  public $proposal;

  public function __construct($id, $uid, $a, $op, $e, $o, $s, $p) {
    parent::__construct();

    $this->id = $id;
    $this->user_id = $uid;
    $this->amount = $a;
    $this->opponent = $op;
    $this->event = $this->set_event($e);
    $this->outcome = $o;
    $this->status = $s;
    $this->proposal = $p;
  }

  public function set_event ($event_id) {
    /*
     * $this->events is inherited from the Database class.
     * cycle through data store to find the event with
     * associated id number
     */
    foreach ($this->events as $event) {
      if ($event->id == $event_id) {
        return $event;
      }
    }
  }
};