<?php
require_once 'classes/Database.php';
require_once 'classes/Event.php';

class Wager extends Database {
  public $id;
  public $timestamp;
  public $user_id;
  public $amount;
  public $opponent_id;
  public $event;
  public $outcome;
  public $status;
  public $proposal;
  public $seen;

  public function __construct($id, $t, $uid, $a, $op, $e, $o, $s, $p, $see) {
    parent::__construct();

    $this->id = $id;
    $this->timestamp = $t;
    $this->user_id = $uid;
    $this->amount = $a;
    $this->opponent_id = $op;
    $this->event = $this->set_event($e);
    $this->outcome = $o;
    $this->status = $s;
    $this->proposal = $p;
    $this->seen =$see;
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
