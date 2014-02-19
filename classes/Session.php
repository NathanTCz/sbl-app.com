<?php
require_once 'classes/Database.php';

class Session extends Database {
  // class data
  private $user_id;


  // Here defines the public funtions used to determine the session information.

  public function __construct () {
    parent::__construct();
  }
/*
Function: redirect
Description: used as normal php header redirect
*/
  public function redirect ($page) {
    header("Location: $page");
  }

/*
Function: logged_in
Description: returns a boolean value signifying if the user is
in fact logged in i.e. if the SESSION variable user_id is set
*/
  public function logged_in () {
    if (isset($_SESSION['user_id'])) return true;
    else return false;
  }

/*
Function: login
Description: Handles login status manipulation
*/
  public function login ($u_id) {
    session_start();
    $_SESSION['user_id'] = $u_id;
    $this->user_id = $u_id;
    
    $user_data = $this->resolve_data($u_id);

    foreach ($user_data as $key => $value) {
      $_SESSION['user'][$key] = $value;
    }

    $this->redirect("/home");
  }

/*
Function: logout
Description: Destroys session data and logs user out.
*/
  public function logout () {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->redirect("/web/main");
  }

  public function resolve_data ($user_id) {
    $stmt = $this->DB->prepare("
      SELECT *
      FROM user
      WHERE user_id = ?                           
    ");

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    
    $meta = $stmt->result_metadata();

    while ($field = $meta->fetch_field()) {
      $parameters[] = &$row[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $parameters);

    while ($stmt->fetch()) {
      foreach($row as $key => $val) {
        $x[$key] = $val;
      }

    $results = $x;
    }

    return $results;
  }

}
