<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

$event_id = $_GET['event_id'];
$cat_id = $_GET['cat'];

foreach ($EVENTS as $event) {
  if ($event->id == $event_id) {

  /* Convert PHP Object to JSON notation
   * so we can send the information to
   * the bet_box that pops up. This needs to
   * be done because the bet_box is above this
   * code in the DOM
   */

  // Home team
  $h = json_encode( (array)$event->home_team );

  // Away team
  $a = json_encode( (array)$event->away_team );
  ?>

  <div class="event_toolbar">
    <span class="icon-arrow-left2"
          onclick="load_list(<?php echo $cat_id?>)"
    >
    </span>
    </span>
    <span class="icon-bookmark"
          title="bookmark this event"
    ></span>
    <span class="icon-coin" 
          onclick="show_bet_box(
                    <?php echo htmlspecialchars($h);?>,
                    <?php echo htmlspecialchars($a);?>,
                    <?php echo $event->id;?>
                  )"
          title="bet on this event"
    >
  </div>

  <div class="event_jumbo">
    <span id="at">VS</span>

    <div id="away_team">
      <span id="score">
      <?php echo
        $event->away_score
        ;
      ?>
      </span>
      <span id="s_name">
      <?php echo
        $event->away_team->short_name;
      ?>
      </span>
      <span id="name">
      <?php echo
        $event->away_team->name;
      ?>
      </span>
    </div>
    <div id="home_team">
      <span id="score">
      <?php echo
        $event->home_score
        ;
      ?>
      </span>
      <span id="s_name">
      <?php echo
        $event->home_team->short_name;
      ?>
      </span>
      <span id="name">
      <?php echo
        $event->home_team->name;
      ?>
      </span>
    </div>
    <div id="event_desc">
      <span>
      <?php echo
        'The ' .
        $event->away_team->name .
        ' face the ' .
        $event->home_team->name .
        ' in ' .
        $event->location .
        ' at ' .
        $event->time .
        ' on ' .
        $event->date
        ;
      ?>
      </span>
    </div>
  </div>

  <?php
  exit;
  }
}
?>