<?php
// YOUR FUCKING LOGIC GOES HERE.
?>

<div id="categ" class="bar">
  <?php
  foreach ($CATEGORIES as $cat) {
  ?>
  <span>
  <?php
    echo $cat->name;
  ?>
  </span>
  <?php
  }
  ?>
</div>

<div id="list" class="bar">
<<<<<<< HEAD
  <div class="head_bar">
  <?php
  $properties = get_object_vars( $EVENTS[0] );
  foreach ($properties as $key => $value) {
    echo '<span>' . $key . '</span>';
  }
  ?>
  </div>
  <?php
  foreach ($EVENTS as $event) {
  ?>
  <span>
  <?php
    echo $event->description;
  ?>
  <br>
  </span>
  <?php
  }
  ?>
</div>
=======
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

>>>>>>> 98294f16c7f172841f57399b1cce093091b9fd74
