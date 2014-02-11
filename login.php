<?php
  require 'core/init.php';

  if ($session->logged_in()) {
    $session->redirect("/home");
    exit;
  }

  if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Create Login Object
    $login = new Login($email, $pass); 

    if ($user_id = $login->auth_user()) {
      $session->login($user_id);
    }
    else {
      $ERRORS[] = "Invalid username and password";
    }
  }

  include 'includes/pages/login.php';
?>
