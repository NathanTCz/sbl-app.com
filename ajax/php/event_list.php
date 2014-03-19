<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

$cat_id = $_GET['cat'];
$dates = array();

// Store dates for categorization
foreach ($EVENTS as $event) {
  if ( !in_array($event->date, $dates)
      &&
      (
        $event->category->id == $cat_id
        || $cat_id == 1
      )
     )
    $dates[] = $event->date;
}

foreach ($dates as $date) {
?>
<div class="date_title">
  <span>
  <?php echo
    $date
    ;
  ?>
  </span>
</div>

<?php
  foreach ($EVENTS as $event) {
    if ($event->category->id == $cat_id
        || $cat_id == 1)
    {
      if ($event->date == $date) {
      ?>

      <div
        id="<?php echo $event->id;?>"
        class="list_item"
        onclick="load_event(this.id, <?php echo $cat_id;?>)"
      >

        <span>
          <?php echo
            $event->away_team->short_name
            . ' vs ' .
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
            $event->away_score
            . ' - ' .
            $event->home_score
            ;
          ?>
        </span>
        <span>
          <?php echo
            $event->description
            ;
          ?>
        </span>
      </div>

      <?php
      }
    }
  }
}
?>