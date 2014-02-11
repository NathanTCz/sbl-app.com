<?php
  ini_set('display_errors',1); 
  error_reporting(E_ALL);

  session_start();

  require_once 'classes/Session.php';
  require_once 'classes/Login.php';
  require_once 'classes/User.php';

  // Set default landing page
  if (!isset($_GET['page'])) {
    $_GET['page'] = "home";
  }

  // GLOBAL VARIABLES
  $ERRORS = array();

  $session = new Session;
?>
