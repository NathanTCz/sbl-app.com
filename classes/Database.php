<?php
// Include relevant child classes;
require_once 'classes/Event.php';
require_once 'classes/Team.php';
require_once 'classes/Wager.php';
require_once 'classes/Yac.php';

class Database {
  public $teams;
  public $wagers;
  public $events;
  public $yacs;
  public $categories;
  public $users;


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
    global $CATEGORIES;
    global $USERS;

    /*
     * Because of control flow, THESE MUST BE SET IN THIS
     * ORDER, BITCH.
     */
    $this->teams = $TEAMS;
    $this->categories = $CATEGORIES;
    $this->events = $EVENTS;
    $this->yacs = $YACS;
    $this->wagers = $WAGERS;
    $this->users = $USERS;
  }

  public static function set_users () {
    global $DB;
    
     $query = $DB->prepare ("
      SELECT *
      FROM user
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

     foreach ($results as $user) {
      $users[] = new User (
        $user->email,
        $user->u_name,
        $user->user_id
      );
    }
    return ( isset($users) ) ? $users : $users = array();
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
    return ( isset($teams) ) ? $teams : $teams = array();
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
        $wager->timestamp,
        $wager->user_id,
        $wager->amount,
        $wager->opponent_id,
        $wager->event_id,
        $wager->wager_outcome,
        $wager->status,
        $wager->proposal,
        $wager->seen,
        $wager->counter_offer_bool
      );
    }
    return ( isset($wagers) ) ? $wagers : $wagers = array();
  }

  public static function set_events () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM event
      ORDER BY event_time ASC
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

    foreach ($results as $event) {
      $events[] = new Event (
        $event->id,
        $event->cat_id, 
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
    return ( isset($events) ) ? $events : $events = array();
  }

  public static function set_yacs () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM yac
    ");
    $query->execute();
    
    $results = Database::resolve_data($query);

    foreach ($results as $yac) {
      $yacs[] = new Yac (
        $yac->id,
        $yac->user_id,
        $yac->at_risk,
        $yac->balance
      );
    }
    return ( isset($yacs) ) ? $yacs : $yacs = array();
  }

  public static function set_categories () {
    global $DB;

    $query = $DB->prepare ("
      SELECT *
      FROM category
      ORDER BY id ASC
    ");
    $query->execute();
    
    $cats = Database::resolve_data($query);

    return ( isset($cats) ) ? $cats : $cats = array();
  }
}
?>
