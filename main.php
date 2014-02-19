<?php
  require 'core/init.php';

  if ($session->logged_in()) {
    $session->redirect("/home");
    exit;
  }

  include 'includes/pages/main.php';
?>