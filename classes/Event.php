<?php
require_once 'classes/Database.php';
require_once 'classes/Team.php';

class Event extends Database {
  //PRIVATE DATA & FUNCTIONS
  private $id;
  private $time;
  private $outcome;
  private $home_team;
  private $home_score;
  private $away_team; 
  private $away_score;
  private $location;
  private $description;
  
  //PUBLIC DATA & FUNCTIONS

  //Constructor
  public function __construct ($id, $t, $o, $ht, $hs, $at, $as, $l, $d) {
    // Explicitly call parent constructor
    parent::__construct();

    $this->id = $id;
    $this->time = $this->set_time($t);
    $this->outcome = $o;
    $this->home_team = $this->set_team($ht);
    $this->home_score = $hs;
    $this->away_team = $this->set_team($at);
    $this->away_score = $as;
    $this->location = $l;
    $this->description = $d;
  } 

  public function set_time ($time) {
    return $time;
  }

  public function get_time () {
    return $this->time;
  }

  public function get_outcome () {
    return $this->outcome;
  }

  public function set_team($team_id) {
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

  public function get_home_team () {
    return $this->home_team;
  }

  public function get_home_score () {
    return $this->home_score;
  }

  public function get_away_team () {
    return $this->away_team;
  }

  public function get_away_score (){
  	return $this->away_score;
  }

}
?>
