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
foreach ($EVENTS as $event) {
  echo '<span class="list_item">';
  echo $event->get_home_team()->name . '<br>';
}
?>
</div>