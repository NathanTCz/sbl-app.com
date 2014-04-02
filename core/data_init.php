  <?php
  /* sort function helper for sorting events by time
   * under date
   */
/*  function compare_event_time($a, $b) {
    $a_time = strtotime($a->timestamp);
    $b_time = strtotime($b->timestamp);

    if ($a_time == $b_time)
      return 0;

    return ($a_time > $b_time) ? -1 : 1;
  }*/

  /* Just ORDER BY in the SQL statement */
  //usort($EVENTS, 'compare_event_time');

  /* 
   * Initial pull from DB
   * Because of control flow, THESE MUST BE SET IN THIS
   * ORDER, BITCH.
   */

  // Clear out old cache data

  if ( $_SERVER['REQUEST_URI'] != '/web/main' ) {
    if ( !apc_exists('TEAMS') ) {
      $TEAMS = Database::set_teams();
      apc_store('TEAMS', new ArrayObject($TEAMS),60);
    }
    else
      $TEAMS = apc_fetch('TEAMS');

    if ( !apc_exists('CATEGORIES') ) {
      $CATEGORIES = Database::set_categories();
      //apc_store('CATEGORIES', new ArrayObject($CATEGORIES),60);
    }
    else
      $CATEGORIES = apc_fetch('CATEGORIES');

    if ( !apc_exists('EVENTS') ) {
      $EVENTS = Database::set_events();
      apc_store('EVENTS', new ArrayObject($EVENTS),60);
    }
    else
      $EVENTS = apc_fetch('EVENTS');
   
    if ( !apc_exists('YACS') ) {
      $YACS = Database::set_yacs();
      //apc_store('YACS', new ArrayObject($YACS),60);
    }
    else
      $YACS = apc_fetch('YACS');
   
    if ( !apc_exists('WAGERS') ) {
      $WAGERS = Database::set_wagers();
      //apc_store('WAGERS', new ArrayObject($WAGERS),60);
    }
    else
      $WAGERS = apc_fetch('WAGERS');
   
    if ( !apc_exists('USERS') ) {
      $USERS = Database::set_users();
      //apc_store('USERS', new ArrayObject($USERS),60);
    }
    else
      $USERS = apc_fetch('USERS');

    //print_r(apc_cache_info());
  }
?>