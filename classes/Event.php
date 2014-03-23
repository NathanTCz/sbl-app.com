<?php
require_once 'classes/Database.php';
require_once 'classes/Team.php';

class Event extends Database {
  //PRIVATE DATA & FUNCTIONS
  public $id;
  public $category;
  public $date;
  public $time;
  public $timestamp;
  public $outcome;
  public $home_team;
  public $home_score;
  public $away_team; 
  public $away_score;
  public $location;
  public $description;
  
  //PUBLIC DATA & FUNCTIONS

  //Constructor
  public function __construct ($id, $cat, $t, $o, $ht, $hs, $at, $as, $l, $d) {
    // Explicitly call parent constructor
    parent::__construct();

    $this->id = $id;
    $this->category = $this->set_cat($cat);
    $this->timestamp = $t;
    $this->set_time($t);
    $this->outcome = $o;
    $this->home_team = $this->set_team($ht);
    $this->home_score = $this->set_score($hs);
    $this->away_team = $this->set_team($at);
    $this->away_score = $this->set_score($as);
    $this->location = $l;
    $this->description = $d;
  }

  public function set_time ($t) {
    $timestamp = explode(' ', $t);

    if ( preg_match("/^(\d+):(\d+):(\d+)$/", $timestamp[1])
        || preg_match("/^(\d+):(\d+)$/", $timestamp[1])
       ) {
      $time = explode(':', $timestamp[1]);

      if ($time[0] > 12) {
        $time[0] -= 12;
        $time[1] .= '<span class="am_pm">pm</span>';
      }
      elseif ($time[0] == 12)
        $time[1] .= '<span class="am_pm">pm</span>';
      elseif ($time[0] < 12)
        $time[1] .= '<span class="am_pm">am</span>';

      $this->time = "$time[0]:$time[1]";
    }
    elseif ( preg_match("/.*(am|pm)/", $timestamp[1]) ) {
      $time = explode(':', $timestamp[1]);
      $end = $time[1];
      $am_pm = $end[2] . $end[3];
      $end[2] = '';
      $end[3] = '';

      $end .= '<span class="am_pm">' . $am_pm . '</span>';
      $this->time = "$time[0]:$end";
    }
    else
      $this->time = $timestamp[1];

    $this->date = $timestamp[0];
  }

  public function set_team ($team_id) {
    /*
     * $this->teams is inherited from the Database class.
     * cycle through data store to find the team with associated
     * id number
     */
    foreach ($this->teams as $team) {
      if ($team->id == $team_id) {
        return $team;
      }
    }
  }

  public function set_cat ($cat_id) {
    /*
     * $this->categories is inherited from the Database class.
     * cycle through data store to find the category with associated
     * id number
     */
    foreach ($this->categories as $category) {
      if ($category->id == $cat_id) {
        return $category;
      }
    }
  }

  public function set_score ($s) {
    if ($s === NULL)
      return '--';
    else
      return $s;
  }
}
?>
