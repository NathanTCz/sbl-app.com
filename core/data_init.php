  <?php
  /* sort function helper for sorting events by time
   * under date
   */
  function compare_event_time($a, $b) {
    $a_time = strtotime($a->timestamp);
    $b_time = strtotime($b->timestamp);

    if ($a_time == $b_time)
      return 0;

    return ($a_time < $b_time) ? -1 : 1;
  }

  /*
   * --------------------- CACHE CONTROL -------------------------
   * This code segment drastically increases the
   * performance of the application by utilizing a caching
   * utility called Alternative PHP Cache. This utility works
   * by caching data in main memory for a specfied time to live.
   * I was able to drastically speed up the load times (both AJAX
   * and initial page loads) by caching our biggest blocks of data,
   * namely the EVENTS and TEAMS. As you may see I have turned off
   * (commented out) storing everything but TEAMS and EVENTS, because
   * of memory size limitations.
   *
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   * IN ORDER TO TAKE ADVANTAGE OF THIS FEATURE YOU MUST HAVE APC
   * INSTALLED AND ACTIVE AS A MODULE IN YOUR LOCAL SERVER CONFIGURATION
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   * 
   * This also constitutes the initial pull from the DB when necessary.
   *
   * Because of control flow, THESE MUST BE SET IN THIS
   * ORDER, BITCH.
   */

  if (
      $_SERVER['REQUEST_URI'] != '/web/main'
      && $_SERVER['REQUEST_URI'] != '/logout.php'
     )
  {
    if ( !apc_exists('TEAMS') ) {
      $TEAMS = Database::set_teams();
      apc_store('TEAMS', new ArrayObject($TEAMS),60);
    }
    else
      $TEAMS = (array)apc_fetch('TEAMS');

    if ( !apc_exists('CATEGORIES') ) {
      $CATEGORIES = Database::set_categories();
      //apc_store('CATEGORIES', new ArrayObject($CATEGORIES),60);
    }
    else
      $CATEGORIES = (array)apc_fetch('CATEGORIES');

    if ( !apc_exists('EVENTS') ) {
      $EVENTS = Database::set_events();
      usort( $EVENTS, 'compare_event_time');
      apc_store('EVENTS', new ArrayObject($EVENTS),60);
    }
    else
      $EVENTS = (array)apc_fetch('EVENTS');
   
    if ( !apc_exists('YACS') ) {
      $YACS = Database::set_yacs();
      //apc_store('YACS', new ArrayObject($YACS),60);
    }
    else
      $YACS = (array)apc_fetch('YACS');
   
    if ( !apc_exists('WAGERS') ) {
      $WAGERS = Database::set_wagers();
      apc_store('WAGERS', new ArrayObject($WAGERS),60);
    }
    else
      $WAGERS = (array)apc_fetch('WAGERS');
   
    if ( !apc_exists('USERS') ) {
      $USERS = Database::set_users();
      apc_store('USERS', new ArrayObject($USERS),60);
    }
    else
      $USERS = (array)apc_fetch('USERS');


/*      $TEAMS = Database::set_teams();
      $CATEGORIES = Database::set_categories();
      $EVENTS = Database::set_events();
      $YACS = Database::set_yacs();
      $WAGERS = Database::set_wagers();
      $USERS = Database::set_users();*/  
  }
?>