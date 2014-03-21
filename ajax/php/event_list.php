<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

/* sort function helper for sorting events by time
 * under date
 */
function compare_event_time($a, $b) {
  if ($a->time == $b->time)
    return 0;

  return ($a->time < $b->time) ? -1 : 1;
}

usort($EVENTS, 'compare_event_time');

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

sort($dates);

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
    $cat_name = $event->category->name;

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
        <span id="cat_name">
          <?php echo
            $cat_name[0] . '<br>' .
            $cat_name[1] . '<br>' .
            $cat_name[2]
            ;
          ?>
        </span>
        <span>
          <?php echo
            $event->away_team->name
            . ' vs ' .
            $event->home_team->name
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