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
