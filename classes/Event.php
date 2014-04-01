<?php

/*
   Author: Benjamin Patton (aslo including project partners Nick Castelli, 
           Joe Deleeuw, and Nathan Cazell)
   Module Name: Event Class
   Description: This module is the Event module. It is used becaused each bet 
   that take place involves an event between two teams. This module 
   is used to set all the necessary data for an event that is used 
   throughout the entire website. Also included in in-line comments as 
   part of description.
   Date Created: 2/27/2014 
*/

//The Event class below utiilizes the templated Database 
//class that interacts with the database frequently. The
//Team class is also required because each event object has 
//two teams associated with it 
require_once 'classes/Database.php';
require_once 'classes/Team.php';

//Begin defining the Event class which inherits/utilizes 
//all of the Database class functionality. 
class Event extends Database {
  
  //PUBLIC DATA & FUNCTIONS
  public $id;          //id of the event. It is unique
  public $category;    //catgory of the event: MLB,NHL,etc
  public $date;        //date of the event
  public $time;        //time the event will begin
  public $timestamp;   //time the event was inserted into the database
  public $outcome;     //determines which team is the winner or loser
  public $home_team;   //home team identification number
  public $home_score;  //score of the home team in order to determine outcome
  public $away_team;   //away team identification number
  public $away_score;  //score of the away team in order to determine outcome 
  public $location;    //location where the event will be played
  public $description; //description of the event: playoff game, regular season, etc. 
  

  //Constructor
  public function __construct ($id, $cat, $t, $o, $ht, $hs, $at, $as, $l, $d) {
    
    // Explicitly call parent constructor
    parent::__construct();

    //Sets all of the data passed into the constructor. Uses public functions in
    //the class to make sure all variables are properly set in order to insert into 
    //the database and perform betting functions 
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

  //This function is used to properly set the time for an event in order to do 
  //error checking and make sure that a user cannot place a bet after the event has 
  //started. In order to due that the time must be in a proper format. The time check 
  //is done in another module
  public function set_time ($t) {
    //The explode function returns an array of strings, each of which is a substring 
    //of string formed by splitting it on boundaries formed by the delimiter. It 
    //essentially splits the string up. 
    $timestamp = explode(' ', $t);

    //preg_match matches the regular expression specified because the time could
    //be in numerous formats
    if ( preg_match("/^(\d+):(\d+):(\d+)$/", $timestamp[1])
        || preg_match("/^(\d+):(\d+)$/", $timestamp[1])
       ) {
      $time = explode(':', $timestamp[1]);

      //The logic below determines whether to set the time to am or pm 
      //and just sets the time to make it display correctly 
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

  //This function sets the team for an event by finding the id 
  //of the correct team in the teams table
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

  //This function sets the category for an event by finding the id
  //of the correct category that is associated with a team or event
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

  //This is the essential function that sets teh score for an event 
  //in order to be displayed to the user on the website
  public function set_score ($s) {
    if ($s === NULL)
      return '--';
    else
      return $s;
  }
}
?>
