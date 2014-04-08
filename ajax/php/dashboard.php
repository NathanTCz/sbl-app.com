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

if ($_GET['action'] == 'bal') {
  include 'ajax/php/dash/balance.php';
}
elseif ($_GET['action'] == 'notifs') {
  include 'ajax/php/dash/notifications.php';
}
?>