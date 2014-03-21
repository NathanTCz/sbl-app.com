<!DOCTYPE html>

<?php 
	include 'includes/head.php';


  $a = strtotime('2014-03-20 21:17:03');
  $b = strtotime('2014-03-20 22:17:03');

  if ($a < $b)
    echo strtotime('now');
  else
    echo time();
?>
<body>
<?php
  include 'includes/widgets/loader.php';
  include 'includes/widgets/success.php';
  include 'includes/widgets/error.php';
  include 'includes/widgets/betbox.php';
?>
<div class="underlay" onclick="hide()"></div>
<div class="wrapper">
<?php
	include 'includes/pages/logbar.php';
	include 'includes/nav.php';
?>

<div class="main">
