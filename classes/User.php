<?php
require_once 'classes/Database.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $u_name;

  

  public function __construct ($email, $un,  $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->u_name = $un;
    $this->email = $email;
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
}
?>
