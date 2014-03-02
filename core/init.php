<?php
  ini_set('display_errors',1); 
  error_reporting(E_ALL);


  require_once 'core/config.php';

  session_start();

  // Make Database connection
  $DB = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

  require_once 'classes/Session.php';
  require_once 'classes/Login.php';
  require_once 'classes/User.php';
  require_once 'classes/System.php';
  require_once 'classes/Database.php';

  // Set default landing page
  if (!isset($_GET['page'])) {
    $_GET['page'] = "home";
  }

  // GLOBAL VARIABLES
  $ERRORS = array();
  $LOG_ERRORS = array();
  $REG_ERRORS = array();

  /* 
   * Initial pull from DB
   * Because of control flow, THESE MUST BE SET IN THIS
   * ORDER BITCH.
   */
  $TEAMS = Database::set_teams();
  $EVENTS = Database::set_events();
  $YACS = Database::set_yacs();
  $WAGERS = Database::set_wagers();
  $USERS = Database::set_users();

  //$DATABASE = new Database;
  $session = new Session;
?>
