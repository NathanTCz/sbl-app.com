<?php
class Team {
  public $id;
  public $name;
  public $short_name;
  public $conference;

  public function __construct($id, $n, $sn, $c) {
    $this->id = $id;
    $this->name = $n;
    $this->short_name = $sn;
    $this->conference = $c;
  }
};
?>
