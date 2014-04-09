<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

/* create current user object because we're outside the scope
 * of index.php which creates the current_user object
 */

if ($session->logged_in()) {
  $current_user = new User($_SESSION['user']['email'],
                           $_SESSION['user']['u_name'],
                           $_SESSION['user_id']
                          );
}
else
  exit;

$bets = array();

if ($_GET['action'] == 'rec') {
  $bets = array_merge(
    $current_user->get_recent_won_bets(),
    $current_user->get_recent_lost_bets()
  );
}
elseif ($_GET['action'] == 'cnt') {
  
}
elseif ($_GET['action'] == 'pen') {
  $bets = $current_user->get_pending_wagers();
}
elseif ($_GET['action'] == 'acc') {
  $bets = $current_user->get_accepted_wagers();
}
elseif ($_GET['action'] == 'den') {
  $bets = $current_user->get_denied_wagers();
}

if ( !empty($bets) ) {
  foreach ($bets as $wager) {
    echo $wager->amount;
  }
}
?>