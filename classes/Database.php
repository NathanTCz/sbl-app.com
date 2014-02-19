<?php
require 'core/config.php';

class Database {
  public $DB;


//PRIVATE FUNCTIONS
  private function resolve_data ($query) {
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
    global$DB_HOST;
    global$DB_USER;
    global$DB_PASS;
    global$DB_NAME;

    $this->DB = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  }
}
?>