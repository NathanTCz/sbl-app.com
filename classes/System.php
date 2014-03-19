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
      if ($wager->proposal == $wager->event->home_id && $wager->event->outcome == 1) {

      $query = $DB->prepare ("
      UPDATE wager
      SET wager_outcome = 1
      WHERE id = ?
    ");
   
    $query->bind_param('d',$wager->id);
    $query->execute();
    }

    elseif ($wager->proposal == $wager->event->away_id && $wager->event->outcome == 0) {

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
}

public function check_time($current_time){
  //On front end, check time, return true/false
  //If time off throw error

  //We should pass the time in as a string if possible. 

  //If the time being passed in, which should be the current time, is greater 
  //(meaning time to bet has passed) greater than the current time then the 
  //wager cannot be placed
  
   if(strtotime($current_time) > time()){
    return false;
   }
}

public function check_and_update_user_balances(){
  //use global user variable, loop through all users and update 
  //balances based on wagers that have status == 1 and have an outcome

  foreach ($this->user_id as $user) {
    
    if($user->user_id == $yacs->$user_id && $wagers->status == 1
        && $wagers->outcome == 1 && $user->user_id == $wagers->user_id){

      $query = $DB->prepare ("
      UPDATE yac
      SET balance = ?, at_risk = ?
      WHERE id = ?
    ");

    $query->bind_param('ddd', $yacs->balance + $wagers->amount, $yacs->at_risk - $wagers->amount, $user->user_id);
    $query->execute();
   }
   
   elseif($user->user_id == $yacs->$user_id && $wagers->status == 1
          && $wagers->outcome == 0 && $user->user_id == $wagers->user_id){

      $query = $DB->prepare ("
      UPDATE yac
      SET balance = ?, at_risk = ?
      WHERE id = ?
    ");

    $query->bind_param('ddd', $yacs->balance - $wagers->amount, $yacs->at_risk - $wagers->amount, $user->user_id);
    $query->execute();
   }

   elseif($user->user_id == $yacs->$user_id && $wagers->status == 1
          && $wagers->outcome == 1 && $user->user_id == $wagers->opponent_id){

      $query = $DB->prepare ("
      UPDATE yac
      SET balance = ?, at_risk = ?
      WHERE id = ?
    ");

    $query->bind_param('ddd', $yacs->balance - $wagers->amount, $yacs->at_risk - $wagers->amount, $user->user_id);
    $query->execute();
   }

   elseif($user->user_id == $yacs->$user_id && $wagers->status == 1
          && $wagers->outcome == 0 && $user->user_id == $wagers->opponent_id){

      $query = $DB->prepare ("
      UPDATE yac
      SET balance = ?, at_risk = ?
      WHERE id = ?
    ");

    $query->bind_param('ddd', $yacs->balance + $wagers->amount, $yacs->at_risk - $wagers->amount, $user->user_id);
    $query->execute();
   }

 }
}

};
?>
