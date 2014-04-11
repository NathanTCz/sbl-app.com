<?php
  ini_set('display_errors',1);
  error_reporting(E_ALL);

  ini_set('memory_limit', '-1');
  ini_set('apc.shm_size', '512M');

  date_default_timezone_set('America/New_York');


  require_once 'core/config.php';

  session_start();

  // Make Database connection
  $DB = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

  require_once 'classes/System.php';
  // init once for use of functions. it will be init again
  // after data_init
  $SYSTEM = new System;

  require_once 'classes/Session.php';
  $session = new Session;

  require_once 'classes/Login.php';
  require_once 'classes/User.php';
  require_once 'classes/Database.php';

  // Set default landing page
  if (!isset($_GET['page'])) {
    $_GET['page'] = "events";
  }

  // GLOBAL VARIABLES
  $ERRORS = array();
  $LOG_ERRORS = array();
  $REG_ERRORS = array();

  // right here is where we need to initilatise the data
  require_once('core/data_init.php');
?>
