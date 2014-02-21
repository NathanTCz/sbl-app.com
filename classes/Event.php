<?php
require_once 'classes/Database.php';

class Event extends Database {
  //PRIVATE DATA & FUNCTIONS
  private $time;
  private $outcome;
  private $home_team;
  private $home_score;
  private $away_team; 
  private $away_score
  private $team_array = array(); //Not sure how I'm gonna handle the array of team objects yet

  
  //PUBLIC DATA & FUNCTIONS

  //Constructor
  public function __construct ($t, $o, $ht, $hs, $at, $as) {
    //Instantiate parent class
    parent::__construct();

    this->time = $t;
    this->outcome = $o;
    this->home_team = $ht;
    this->home_score = $hs;
    this->away_team = $at;
    this->away_score = $as; 
  } 


  public function get_time () {
        return this->time;
  }

  public function get_outcome () {
        return this->outcome;
  }

  public function get_home_team () {
        return this->home_team;
  }

  public function get_home_score () {
        return this->home_score;
  }

  public function get_away_team () {
        return this->away_team;
  }

  public function get_away_score (){
  	return this->away_score;
  }

}
?>
