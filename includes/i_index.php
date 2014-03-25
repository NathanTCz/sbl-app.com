<?php
  if (isset($_GET['page'])) {
    $page = 'includes/pages/' . $_GET['page'] . '.php';
    if ( is_file($page) ) {
      include $page;
    }
    else include 'includes/pages/404.php';
  }
?>
