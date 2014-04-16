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
  public $status_in_text;
  public $proposal;
  public $prop_team;
  public $seen;
  public $counter_bool;
  public $paid_out;

  public function __construct($id, $t, $uid, $a, $op, $e, $o, $s, $p, $see, $cb, $po) {
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
    $this->prop_team = $this->set_prop_team($s);
    $this->seen =$see;
    $this->counter_bool = $cb;
    $this->paid_out = $po;
    $this->status_in_text = $this->set_stat($s);
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

  public function set_prop_team ($team_id) {
    if ($this->proposal == $this->event->home_team->id)
      return $this->event->home_team;
    else
      return $this->event->away_team;
  }

  public function set_stat ($status) {
    if ($status === 0 && $this->outcome === NULL)
      return 'Denied';

    elseif ($status === 1 && $this->outcome === NULL)
      return 'Accepted';

    elseif ($status === NULL && $this->outcome === NULL)
      return 'Pending';

    elseif ($this->user_id == $this->user_id && $this->outcome === 1)
      return 'won';

    elseif($this->user_id == $this->opponent_id && $this->outcome === 0)
      return 'won';

    elseif($this->user_id == $this->user_id && $this->outcome === 0)
      return 'lost';

    elseif($this->user_id == $this->opponent_id && $this->outcome === 1)
      return 'lost';
  }
};
