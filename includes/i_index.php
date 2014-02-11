<?php
$pages = array("home", "bets", "live");

  if (isset($_GET['page'])) {
    if (in_array($_GET['page'], $pages)) {
      include 'includes/pages/' . $_GET['page'] . '.php';
    }
    else include 'includes/pages/404.php';
  }
?>
