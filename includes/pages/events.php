<?php
// YOUR FUCKING LOGIC GOES HERE.
if ( isset($_GET['id']) )
  $id = $_GET['id'];
else $id = 1;
?>

<div id="categ" class="bar">
  <?php
  foreach ($CATEGORIES as $cat) {
  ?>
  <span id="<?php echo $cat->id?>" onclick="load_list(this.id)">
    <?php echo $cat->name;?>
    <div class="menu_sel"></div>
  </span>
  <?php
  }
  ?>
</div>

<div id="list" class="bar">
  <div id="loader" style="display: none;">
    <span id="spinner" class="icon-spinner4"></span>
  </div>
</div>


<!--
Must load the script after all of the other elements are loaded 
-->
<script src="ajax/js/events.js"></script>