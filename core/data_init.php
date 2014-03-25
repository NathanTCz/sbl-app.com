  <?php
  /* sort function helper for sorting events by time
   * under date
   */
  function compare_event_time($a, $b) {
    $a_time = strtotime($a->timestamp);
    $b_time = strtotime($b->timestamp);

    if ($a_time == $b_time)
      return 0;

    return ($a_time > $b_time) ? -1 : 1;
  }

  usort($EVENTS, 'compare_event_time');
?>