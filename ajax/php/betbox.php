<?php
$home_team = json_decode( $_POST['home'] );
$away_team = json_decode( $_POST['away'] );
$event_id = $_POST['e_id'];
?>

<div id="prop">
  <span id="home" class="selected" onclick="set_proposal(this, <?php echo $home_team->id;?>)">
    <?php echo
      $home_team->short_name
      ;
    ?></span>
  <span id="vs">vs</span>
  <span id="away" onclick="set_proposal(this, <?php echo $away_team->id;?>)">
    <?php echo
      $away_team->short_name
      ;
    ?></span>
  <input id="proposal" type="hidden" value="<?php echo $home_team->id;?>"/>
</div>

<div class="op_amnt">
  <div id="amnt">
    <span class="icon-coin"></span>
    <input id="amount" type="number"/>
    <input id="event_id" type="hidden" value="<?php echo $event_id;?>"/>
  </div>

  <div id="op">
    <input id="opponent" type="text" placeholder="opponent email or username"/>
  </div>
</div>

<div class="buttons">
  <div id="cancel">
    <span onclick="hide()">Cancel</span>
  </div>

  <div id="request">
    <span onclick="submit_request()">Send Request</span>
  </div>
</div>
