<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

$event_id = $_GET['event_id'];

foreach ($EVENTS as $event) {
  if ($event->id == $event_id) {
  ?>

  <div class="event_jumbo">
    <span id="at">AT</span>

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

    <div id="bet_button">
      <span onclick="show_bet_box()">BET ON THIS GAME</span>
    </div>
  </div>

  <div id="bet_box" class="bet_box">

  </div>

  <?php
  }
}
?>