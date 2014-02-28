<?php
require_once 'classes/Database.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $u_name;

  private $pending_wagers;
  private $accepted_wagers;

  

  public function __construct ($email, $un,  $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->u_name = $un;
    $this->email = $email;

    $this->set_pending_wagers();
    $this->set_accepted_wagers();
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

  public function set_pending_wagers () {
    /*
     * $this->wagers is inherited from the Database class.
     */
    foreach ($this->wagers as $wager) {
      if (
            (
            $this->user_id == $wager->user_id
            || $this->user_id == $wager->opponent_id
            ) 
          && $wager->status === NULL
          )
      {
        $this->pending_wagers[] = $wager;
      }
    }
  }

  public function set_accepted_wagers () {
    foreach ($this->wagers as $wager) {
      if ($this->user_id == $wager->user_id
          && $wager->status == 1
          )
      {
        $this->accepted_wagers[] = $wager;
      }
    }
  }
};
?>
