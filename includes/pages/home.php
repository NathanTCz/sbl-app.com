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
