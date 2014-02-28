<?php
require_once 'classes/Database.php';

class System extends Database {
  public function __construct() {
    parent::__construct();
  }

  public function get_events() {
    return $this->events;
  }

  public function get_teams() {
    return $this->teams;
  }
};
?>