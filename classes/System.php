<?php
require_once 'classes/Database.php';

class System extends Database {
  public function __construct() {
    parent::__construct();
  }

  public function get_userid($email){
    $query = $DB->prepare ("
      SELECT user_id
      FROM user
      WHERE
        (
          email = ?
          OR u_name = ?
        )
    ");
   
    $query->bind_param('ss', $email, $email);
    $query->execute();
    $query->bind_result($id);
    $query->fetch();

    return $id;
  }

  public function set_event_outcome(){
   
  	foreach ($this->events as $event) {
  		if($event->home_score > $event_away_score){
  			$query = $DB->prepare ("
      UPDATE event
      SET outcome = 1
      WHERE id = ?
    ");
   
    $query->bind_param('d',$event->id);
    $query->execute();
    
  	}
  	else{
      $query = $DB->prepare ("
      UPDATE event
      SET outcome = 0
      WHERE id = ?
    ");

    $query->bind_param('d',$event->id); 
    $query->execute();
    
   	}
   }
 }

  public function set_wager_outcome(){

    foreach ($this->wagers as $wager) {
      if($wager->proposal == $wager->event->home_id && $wager->event->outcome == 1)

      $query = $DB->prepare ("
      UPDATE wager
      SET wager_outcome = 1
      WHERE id = ?
    ");
   
    $query->bind_param('d',$wager->id);
    $query->execute();
    }
    elseif($wager->proposal == $wager->event->away_id && $wager->event->outcome == 0)

      $query = $DB->prepare ("
      UPDATE wager
      SET wager_outcome = 1
      WHERE id = ?
    ");
   
    $query->bind_param('d',$wager->id);
    $query->execute();
  }
  elseif($wager->proposal == $wager->event->home_id && $wager->event->outcome == 0){

    $query = $DB->prepare ("
      UPDATE wager
      SET wager_outcome = 0
      WHERE id = ?
    ");
   
    $query->bind_param('d',$wager->id);
    $query->execute();
  }
  elseif($wager->proposal == $wager->event->away_id && $wager->event->outcome == 1){

    $query = $DB->prepare ("
      UPDATE wager
      SET wager_outcome = 0
      WHERE id = ?
    ");
   
    $query->bind_param('d',$wager->id);
    $query->execute();
  }
}

public function check_time(){
  //On front end, check time, return true/false
  //If time off throw error
}

public function check_and_update_user_balance(){
  //use global user variable, loop through all users and update 
  //balances based on wagers that have status == 1 and have an outcome
}

};
?>