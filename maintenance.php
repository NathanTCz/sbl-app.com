<?php
  require_once 'core/init.php';

  if ( isset($_GET['e'])
      && $_GET['e'] == '1') {
    $SYSTEM->set_event_outcome();
  }
  if ( isset($_GET['w'])
      && $_GET['w'] == '1') {
    $SYSTEM->set_wager_outcome();
  }
  if ( isset($_GET['u'])
      && $_GET['u'] == '1') {
    $SYSTEM->check_and_update_user_balances();
  }

?>