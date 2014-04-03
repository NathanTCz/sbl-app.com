<?php

/*
   Author: Benjamin Patton (aslo including project partners Nick Castelli, 
           Joe Deleeuw, and Nathan Cazell)
   Module Name: event_list.php                               
   Description: This module is used on our website to display events to the user. It sorts 
   the events and uses a front end css to display the events in a user friendly 
   fashion. Also included in in-line comments as part of description
   Date Created: 2/27/2014 
*/

/* 
  This moves back to the server root dir so that
  so that includes and such work correctly
*/
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

//Have to require the init.php file to interact with the database correctly
require_once 'core/init.php';

//Function takes in 2 dates to compare them in order to display events 
//in the correct order by date
function compare_event_date($a, $b) {
  $a_date = strtotime($a);
  $b_date = strtotime($b);

  if ($a_date == $b_date)
    return 0;

  return ($a_date < $b_date) ? -1 : 1;
}

//Gets the category id of an event
$cat_id = $_GET['cat'];

//Array holding all of the dates of the events
$dates = array();

//Stores the dates for categorization based on the category id
foreach ($EVENTS as $event) {
  if ($cat_id != 9) {
    if ( !in_array($event->date, $dates)
        &&
        (
          $event->category->id == $cat_id
          || $cat_id == 1
        )
        && strtotime($event->date) >= strtotime(date('n/j/Y'))
       )
      $dates[] = $event->date;
  }
  elseif ( !in_array($event->date, $dates)
          && strtotime($event->date) < strtotime( date('n/j/Y') )
          && $cat_id == 9
          )
    $dates[] = $event->date;
}

//Built in php function to sort the dates as defined in the 
//in the function above
usort($dates, 'compare_event_date');

//Goes through each date in the array and displays the dates
foreach ($dates as $date) {
?>
<div class="date_title">
  <span>
  <?php echo
    $SYSTEM->date2words($date)
    ;
  ?>
  </span>
</div>

<?php
  //Goes through each event in the database and gets the category, 
  //and will then display the event under the correct date determined 
  //previously by going through the events array
  foreach ($EVENTS as $event) {
    $cat_name = $event->category->name;

    if ($event->category->id == $cat_id
        || $cat_id == 1
        || $cat_id == 9
        )
    {
      if ($event->date == $date) {
      ?>

      <div
        id="<?php echo $event->id;?>"
        class="list_item"
        onclick="load_event(this.id, <?php echo $cat_id;?>)"
      >
        <span id="cat_name">
          <?php echo
            $cat_name[0] . '<br>' .
            $cat_name[1] . '<br>' .
            $cat_name[2]
            ;
          ?>
        </span>
        <span>
          <?php echo //Display who is facing each other in the event
            $event->away_team->name
            . ' vs ' .
            $event->home_team->name
            ;
          ?>
        </span>
        <span>
          <?php echo //Diplay the beginning time of the event
            $event->time
            ;
          ?>
        </span>
        <span>
          <?php echo //Display the scores of the two teams 
            $event->away_score
            . ' - ' .
            $event->home_score
            ;
          ?>
        </span>
        <span>
          <?php echo //Diplay the discription of the event
            $event->description
            ;
          ?>
        </span>
      </div>

      <?php
      }
    }
  }
}
?>