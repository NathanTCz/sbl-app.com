<?php
  require_once 'core/init.php';
  
  $SYSTEM->set_event_outcome();
  $SYSTEM->set_wager_outcome();

  $SYSTEM->check_and_update_user_balances();

?>