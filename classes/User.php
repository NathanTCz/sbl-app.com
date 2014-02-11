<?php
require_once 'classes/Database.php';

Class User extends Database {
  private $user_id;
  private $email;

  

  public function __construct ($email, $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->email = $email;
  }

  public function get_email () {
    return $this->email;
  }

  public function get_uid () {
    return $this->user_id;
  }
}
?>
