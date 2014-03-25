<?php
  require_once 'core/init.php';

  if (!$session->logged_in()) {
    $session->redirect("/web/main");
        exit;
  }
  else if ($session->logged_in()) {
    $current_user = new User($_SESSION['user']['email'],
                             $_SESSION['user']['u_name'],
                             $_SESSION['user_id']
                            );
  }
  
  include 'includes/main/header.php';
  flush();

  // right here is where we need to initilatise the data
  require_once('core/data_init.php');

  include 'includes/i_index.php';
  include 'includes/main/footer.php';
?>

