<?php
// YOUR FUCKING LOGIC GOES HERE.
?>

<div id="categ" class="bar">
  <span>Football</span>
  <span>Baseball</span>
  <span>Basketball</span>
  <span>Soccer</span>
  <span>Other</span>
</div>

<div id="list" class="bar">
 <?php  
  
    //Nate dog how can I access the current user's id here
    //I tried almost everything. Like $DB, $DB->get_uid(), etc. 
    //All i want is to access the current uer's id so i can propperly print things
    //Cuz it helps me figure out logic. Also, I added more wagers in the database 

   foreach ($WAGERS as $wager) {
     echo '<span class="list_item">';
     foreach ($EVENTS as $event) {     
         if ($event->id == $wager->event) {
     	    if($wager->outcome == 1){ // && $DB->get_uid() == $wager->user_id) {// && ($event->$DB->get_uid() != $event->opponenet_id)){
     	   	    echo "You won $" . $wager->amount . "! <br>";
     	    }
     	    elseif ($wager->outcome == 0) {// && ($event->$DB->get_uid() != $event->opponenet_id)) {
     	    	echo "Sorry you lost $" . $wager->amount . ". Please try again fucker :) <br>";
     	    }
        	else {
      	    	echo "This event, " . $wager->away_team . " vs. " . $event->home_team . " has not concluded. <br>";     	}
         }
     }
   }
 ?>
</div>

