<?php
  require 'core/init.php';

  if ($session->logged_in()) {
    $session->redirect("/events");
    exit;
  }

  include 'includes/pages/main.php';
?>
