<?php
require_once 'classes/Database.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $u_name;

  private $pending_wagers;
  private $accepted_wagers;
  private $denied_wagers;

  private $yac;
  

  public function __construct ($email, $un,  $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->u_name = $un;
    $this->email = $email;

    $this->set_pending_wagers();
    $this->set_accepted_wagers();
    $this->set_denied_wagers();

    $this->set_yac();
  }

  public function get_email () {
    return $this->email;
  }

  public function get_uname () {
    if ($this->u_name === "")
      return $this->get_email();
    else
      return $this->u_name;
  }

  public function get_uid () {
    return $this->user_id;
  }

  public function set_yac () {
    /*
     * $this->yacs is inherited from the Database class.
     * cycle through data store to find the yac with associated
     * id number
     */
    foreach ($this->yacs as $yac) {
      if ($yac->user_id == $this->user_id) {
        $this->yac = $yac;
      }
    }
  }

  /*
  public function event_outcome () {
    echo "BELOW IS A LIST OF YOUR PERSONAL RELEVANT WAGER INFO (NOT INCLUDING DENIED WAGERS). <br>";
    
    foreach($this->wagers as $wager) {
    if (($wager->outcome == 1 && $this->user_id == $wager->user_id && $wager->status == 1)
         || $wager->outcome == 0 && $this->user_id == $wager->opponent_id && $wager->status == 1){ 
          echo "You won $" . $wager->amount . "! <br>";
      }
      elseif (($wager->outcome == 0 && $this->user_id == $wager->user_id && $wager->status == 1)
              || $wager->outcome == 1 && $this->user_id == $wager->opponent_id && $wager->status == 1){
          echo "Sorry you lost $" . $wager->amount . ". Please try again fucker :) <br>";
      }
      elseif ($wager->status === NULL && $this->user_id == $wager->user_id) { 
          echo "The wager on event, " . $wager->event . ", for $" . $wager->amount . " is pending OPPONENT'S authorization. <br>";
        }
      elseif ($wager->status === NULL && $this->user_id == $wager->opponent_id) {
          echo "The wager on event, " . $wager->event . ", for $" . $wager->amount . " is pending YOUR authorization. <br>";       
      }
      else 
        ;
    }
  }*/

  public function set_pending_wagers () {
    /*
     * $this->wagers is inherited from the Database class.
    */
    foreach ($this->wagers as $wager) {
      if ($this->user_id == $wager->user_id && $wager->status === NULL){
        $this->pending_wagers[] = $wager;
      }
      elseif($this->user_id == $wager->opponent_id && $wager->status === NULL){
        $this->pending_wagers[] = $wager;
      }
    }
  }

  public function set_accepted_wagers () {
    foreach ($this->wagers as $wager) {
      if ($this->user_id == $wager->user_id && $wager->status === 1){
        $this->accepted_wagers[] = $wager;
      }
      elseif($this->user_id == $wager->opponent_id && $wager->status === 1){
        $this->accepted_wagers[] = $wager;
      }
    }
  }

  public function set_denied_wagers () {
    foreach ($this->wagers as $wager) {
      if ($this->user_id == $wager->user_id && $wager->status === 0){
        $this->denied_wagers[] = $wager;
      }
      elseif($this->user_id == $wager->opponent_id && $wager->status === 0){
        $this->denied_wagers[] = $wager;
      }
    }
  }

  public function get_denied_wagers () {
    return $this->denied_wagers;
  }

  public function get_accepted_wagers () {
    return $this->accepted_wagers;
  }

  public function get_pending_wagers () {
    return $this->pending_wagers;
  }



  public function make_wager ($opponent_id, $amount, $proposal, $event_id) {
    $query = $DB->prepare ("
      INSERT INTO wager (
        user_id,
        amount,
        proposal,
        opponent_id,
        event_id
      )
      VALUES (?,?,?,?,?)
    ");

    $query->bind_param('ddddd', $this->user_id, $amount, 
                     $proposal, $opponent_id,$event_id);
    $query->execute();


  }

  public function check_yacs ($amount) {
    //Check to make sure user has enough funds to support the bet

    if($this->balance < $amount)
      return false; 
    else 
      return true; 
  }

  public function accept_request ($bet_id) {
      //update at risk and balance of both users
      //$bet_id is the wager_id of the event that should get passed in 

      //How can I set the opponent's balance and at risk amount???

      $query = $DB->prepare ("
      UPDATE yac, wager
      SET yac.balance = ?, yac.at_risk = ?, wager.status = ?
      WHERE wager.id = ? AND yac.user_id = ? 
    ");

    $query->bind_param('dddd', $yacs->balance - $wagers->amount, $yacs->at_risk + $wagers->amount, 
                       1, $bet_id, $this->user_id) ;
    $query->execute();
   
  }

  public function deny_request ($bet_id) {
    //Maybe when a user denies a request we go ahead & delete that entry from the wager table?  
    //or do we want to keep it so we can display denied wagers?? Anytime a wager is denied we could
    //just send them a message saying the wager was denied and then after the message displays
    //delete the wager from the table. 

     $query = $DB->prepare ("
      UPDATE wager
      SET status = ?
      WHERE id = ?  
    ");

    $query->bind_param('dddd', 0, $bet_id) ;
    $query->execute();

  }

  public function counter_offer ($bet_id, $counter_amount) {
    //they can counter propose an amount for now
  
      $query = $DB->prepare ("
      UPDATE wager
      SET  counter_offer = ?, amount = ?
      WHERE id = ? 
    ");

    $query->bind_param('dddd', 1, $counter_amount, $bet_id) ;
    $query->execute();
   

  }

  public function update_balance () {
    //update user's funds based on bet outcomes. use event_outcome 
    //logic and then update tables 
  }

};
?>
