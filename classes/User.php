<?php
require_once 'classes/Database.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $u_name;

  private $pending_wagers;
  private $accepted_wagers;
  private $denied_wagers;

  

  public function __construct ($email, $un,  $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->u_name = $un;
    $this->email = $email;

    $this->set_pending_wagers();
    $this->set_accepted_wagers();
    $this->set_denied_wagers();
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
  }

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

};
?>
