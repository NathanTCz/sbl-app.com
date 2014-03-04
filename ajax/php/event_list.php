<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

$cat_id = $_GET['cat'];

foreach ($EVENTS as $event) {
  if ($event->category->id == $cat_id
      || $cat_id == 1)
  {
  ?>

  <div class="list_item">
    <span>
      <?php echo
        $event->away_team->short_name
        . ' at ' .
        $event->home_team->short_name
        ;
      ?>
    </span>
    <span>
      <?php echo
        $event->time
        ;
      ?>
    </span>
    <span>
      <?php echo
        $event->date
        ;
      ?>
    </span>
    <span>
      <?php echo
        $event->away_score
        . ' - ' .
        $event->home_score
        ;
      ?>
    </span>
  </div>

  <?php
  }
}
?>

<div id="loader" style="display: none;">
  <span id="spinner" class="icon-spinner4"></span>
</div>