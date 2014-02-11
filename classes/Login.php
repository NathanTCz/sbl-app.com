<?php
require_once 'classes/Database.php';

class Login extends Database {
// PRIVATE DATA
  private $email;
  private $pass;


  // Private Helper Functions.
  private function set_pass ($p, $e) {
    $this->pass = $this->salt($p, $e);
  }

  private function salt ($pass, $salt) {
    $pass = $pass . md5($salt);

    for ($i = 0; $i < 5; $i++) {
      $pass = md5($pass);
    }

    return $pass;
  }



//PUBLIC MEMBER FUNCTIONS
  public function __construct ($e, $p, $z = 0) {
    // Instantiate parent object
    parent::__construct();

    $this->email = $e;
    $this->set_pass($p, $e);
  }

  public function auth_user () {
    global $ERRORS;

    $query = $this->DB->prepare ("
      SELECT user_id
      FROM user
      WHERE email = ?
      AND password = ?
    ");

    $query->bind_param('ss', $this->email, $this->pass);
    $query->execute();
    $query->bind_result($id);
    $query->fetch();

    if (isset($id) && $id !== 0) {
      return $id;
    }
    else {
      return false;
    }
  }

  public function register_user () {
    global $ERRORS;

    if($this->new_user()) {
      $query = $this->DB->prepare ("
        INSERT INTO user (
          email,
          password
        )
        VALUES (?,?)
      ");

      $query->bind_param('ss', $this->email, $this->pass);
      $query->execute();
      return true;
    }
    else { 
      $ERRORS[] = "A user with that email already exists";
      return false;
    }
  }

  public function new_user () {
    global $ERRORS;

    $query = $this->DB->prepare ("
      SELECT user_id
      FROM user
      WHERE email = ?
    ");

    $query->bind_param('s', $this->email);
    $query->execute();
    $query->bind_result($count);
    $query->fetch();

    if ($count == NULL)
      return true;
    else
      return false;
  }

}
?>
