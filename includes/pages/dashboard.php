<?php
  $balance = $current_user->yac->balance;
  $at_risk = $current_user->yac->at_risk;

  $bal_width = $balance / ($balance + $at_risk) * 100;
  $ar_width = $at_risk / ($balance + $at_risk) * 100;

  //$ar_top = $balance / ($balance + $at_risk) * 10;
  //$bal_top = $at_risk / ($balance + $at_risk) * 10;

$dash_navs = array('Balance' => 'bal',
                     'dashboard' => 'icon-dashboard',
                     'bets' => 'icon-ticket',
                     'live' => 'icon-feed'
                    );
?>

<div class="dash">
  <div class="dash_nav">
    <?php
    foreach ($nav_buttons as $name => $action) {
    ?>
    <span
      id="<?php echo $action;?>"
      onclick="load_dash(this.id)"
    >
      <?php echo
        $name
        ;
      ?>
    </span>
    <?php
    }
    ?>
  </div>
  <div class="dash_main">
    <div id="bal" class="bal_box">
      <span>
        <?php echo
          $balance;
        ?>
        <span>Balance</span>
      </span>
    </div>
    <div id="ar" class="bal_box">
      <span>
        <?php echo
          $at_risk;
        ?>
        <span>At Risk</span>
      </span>
    </div>

    <div class="bal_bar">
      <div id="balance"></div>
      <div id="at_risk"></div>
    </div>
  </div>
</div>

<script>
setTimeout(function(){
  return set_width(<?php echo $bal_width;?>, <?php echo $ar_width;?>);
}, 200);

function set_width(b, a) {
  document.getElementById('balance').style.width = b + '%';
  document.getElementById('at_risk').style.width = a + '%';
}
</script>