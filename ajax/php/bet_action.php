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

$prop = $_POST['prop'];
$amnt = $_POST['amnt'];
$opp = $_POST['opp'];
//echo $_POST['event'];
$event = json_decode( $_POST['event'] );
print_r($event);

// get the opponent user_id
$opp = $SYSTEM->get_userid($opp);

if ( $current_user->make_wager($opp, $amnt, $prop, $event->id) )
  if ( $SYSTEM->check_time($event->timestamp) )
    echo 'OK';
else
  echo 'ERROR';
?>