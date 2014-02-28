<?php
require_once 'classes/Database.php';

class Login extends Database {
// PRIVATE DATA
  private $email;
  private $pass;
  private $prepass;

  // Private Helper Functions.
  private function set_pass ($p) {
    $this->prepass = $p;
    $this->pass = $this->salt($p);
  }

  private function salt ($pass) {
    $pass = $pass . sha1($pass);

    for ($i = 0; $i < 100; $i++) {
      $pass = sha1($pass) . sha1($pass);
    }

    return $pass;
  }



//PUBLIC MEMBER FUNCTIONS
  public function __construct ($e, $p) {
    $this->email = $e;
    $this->set_pass($p);
    }

  public function auth_user () {
    global $ERRORS;
    global $DB;

    $query = $DB->prepare ("
      SELECT user_id
      FROM user
      WHERE
        (
          email = ?
          OR u_name = ?
        )
      AND password = ?
    ");


    /*
     * Here, $this->email could either refer to the users email
     * or their username depending upon what they type in.
     * The query is already case insensitive so we need not worry
     * about what the user types in as far as Upper Case and
     * Lower Case.
     */
    $query->bind_param('sss', $this->email, $this->email, $this->pass);
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
    global $REG_ERRORS;
    global $DB;

    if($this->new_user() && $this->validate_email() && $this->validate_password()) {
      $query = $DB->prepare ("
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
      return false;
    }
  }

  public function new_user () {
    global $REG_ERRORS;
    global $DB;

    $query = $DB->prepare ("
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
      $REG_ERRORS[] = "A user with this email already exists";
      return false;
  }
 
  public function validate_email()
  { 
    global $REG_ERRORS; 
    
    $result = filter_var($this->email, FILTER_VALIDATE_EMAIL);
    if ($result == false)
    {
      $REG_ERRORS[] = "An invalid email address has been entered";
    }
    return $result; 
  }
 
 public function validate_password()
 {
  global $REG_ERRORS;

  if(strlen($this->prepass) < 6 )
    {
      $REG_ERRORS[] = "Password must have at least 6 characters";
    }

  if(strlen($this->prepass) > 20)
  {
    $REG_ERRORS[] = "Password must be less than 20 characters";
  }

  if(!preg_match("#[0-9]+#", $this->prepass))
  {
    $REG_ERRORS[] = "Password must contain at least one number";
  }

 if(!preg_match("#[a-z]+#", $this->prepass))
  {
    $REG_ERRORS[] = "Password must contain at least one letter";
  }
 
 if(!preg_match("#[A-Z]+#", $this->prepass))
  {
    $REG_ERRORS[] = "Password must contain at least one uppercase letter";
  }
  if(empty($REG_ERRORS))
  {
    return true;
  }
  else 
    return false;
  
  }
}
?>
