<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
//$root_dir = $_SERVER['DOCUMENT_ROOT'];
$root_dir = '/srv/http';
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

  $last_recieved = $_GET['ts'];
  $go = true;

  $response_data = array();

  while ($go) {
    $new_wager = $SYSTEM->get_wager()[0];

    $new_recieved = strtotime($new_wager->timestamp);

    if ($new_recieved > $last_recieved) {
      $go = false;

      $response_data['data'] = 
        '<span>' . 
        $new_wager->event->location .
        '</span>'
        ;

      $response_data['new_ts'] = $new_recieved;

      echo json_encode($response_data);
    }
  }
?>