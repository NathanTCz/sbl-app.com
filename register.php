<?php
  include 'core/init.php';

  if ($session->logged_in()) {
    $session->redirect("/home");
    exit;
  }

  if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password2']);

    // Create Login Object
    $login = new Login($email, $pass); 

    if ($login->register_user())
      $session->redirect("/web/regcomp");
  }
  include 'includes/pages/register.php';
?>
