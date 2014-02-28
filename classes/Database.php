<?php
// Include relevant child classes;
require_once 'classes/Event.php';
require_once 'classes/Team.php';
require_once 'classes/Wager.php';

class Database {
  public $DB;
  public $teams;
  public $wagers;
  public $events;
  public $yacs;



//PRIVATE FUNCTIONS
  public static function resolve_data ($query) {
    $meta = $query->result_metadata();

    while ($field = $meta->fetch_field()) {
      $parameters[] = &$row[$field->name];
    }

    call_user_func_array(array($query, 'bind_result'), $parameters);
    
    $results = array();

    while ($query->fetch()) {
      $obj = new stdClass();

      foreach($row as $key => $val) {
        $obj->$key = $val;
      }

      $results[] = $obj;
    }

    return $results;
  }


//PUBLIC FUNCTIONS
  public function __construct () {
    global $TEAMS;
    global $EVENTS;
    global $YACS;
    global $WAGERS;

    /*
     * Because of control flow, THESE MUST BE SET IN THIS
     * ORDER BITCH.
     */
    $this->teams = $TEAMS;
    $this->events = $EVENTS;
    $this->yacs = $YACS;
    $this->wagers = $WAGERS;
  }

  public static function set_teams () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM team
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

    foreach ($results as $team) {
      $teams[] = new Team (
        $team->id,
        $team->name,
        $team->short_name,
        $team->conference
      );
    }
    return $teams;
  }

  public static function set_wagers () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM wager
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

    foreach ($results as $wager) {
      $wagers[] = new Wager (
        $wager->id,
        $wager->user_id,
        $wager->amount,
        $wager->opponent_id,
        $wager->event_id,
        $wager->wager_outcome,
        $wager->status
      );
    }
    return $wagers;
  }

  public static function set_events () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM event
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

    foreach ($results as $event) {
      $events[] = new Event (
        $event->id,
        $event->event_time,
        $event->outcome,
        $event->home_id,
        $event->home_score,
        $event->away_id,
        $event->away_score,
        $event->location,
        $event->description
      );
    }
    return $events;
  }

  public static function set_yacs () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM yac
    ");
    $query->execute();
    
    $yacs = Database::resolve_data($query);

    return $yacs;
  }
}
?>
