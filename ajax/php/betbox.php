<?php
$home_team = json_decode( $_POST['home'] );
$away_team = json_decode( $_POST['away'] );
?>

<div id="prop">
  <span id="home" class="selected" onclick="set_outcome(this, <?php echo $home_team->id;?>)">
    <?php echo
      $home_team->short_name
      ;
    ?></span>
  <span id="or">or</span>
  <span id="away" onclick="set_outcome(this, <?php echo $away_team->id;?>)">
    <?php echo
      $away_team->short_name
      ;
    ?></span>
  <input id="proposal" type="hidden"/>
</div>

<div class="op_amnt">
  <div id="amnt">
    <span class="icon-coin"></span>
    <input id="amount" type="number"/>
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
    <span>Send Request</span>
  </div>
</div>
