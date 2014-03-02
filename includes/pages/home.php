<?php
// YOUR FUCKING LOGIC GOES HERE.
?>

<div id="categ" class="bar">
  <span>Football</span>
  <span>Baseball</span>
  <span>Basketball</span>
  <span>Soccer</span>
  <span>Other</span>
</div>

<div id="list" class="bar">
 <?php     

    $current_user->event_outcome();
    

    $pw = $current_user->get_pending_wagers();
    $dw = $current_user->get_denied_wagers();
    $aw = $current_user->get_accepted_wagers();
   
    foreach ($pw as $cur) {
      echo "Your pending wagers are " . $cur->id . ".<br>";
    }

    foreach ($dw as $cur) {
      echo "Your denied wagers are " . $cur->id . ".<br>";
    }

    foreach ($aw as $cur) {
      echo "Your accepted wagers are " . $cur->id . ".<br>";
    }
 ?>
</div>

