<?php
  $balance = $current_user->yac->balance;
  $at_risk = $current_user->yac->at_risk;

  $bal_width = $balance / ($balance + $at_risk) * 100;
  $ar_width = $at_risk / ($balance + $at_risk) * 100;

  //$ar_top = $balance / ($balance + $at_risk) * 10;
  //$bal_top = $at_risk / ($balance + $at_risk) * 10;
?>

<div class="dash">
  <div class="dash_nav">
    <span>Balance</span>
  </div>
  <div class="dash_main">
    <div id="bal" class="bal_box" style="margin-top:<?php echo $bal_top;?>%">
      <span>
        <?php echo
          $balance;
        ?>
        <span>Balance</span>
      </span>
    </div>
    <div id="ar" class="bal_box" style="margin-top:<?php echo $ar_top;?>%">
      <span>
        <?php echo
          $at_risk;
        ?>
        <span>At Risk</span>
      </span>
    </div>

    <div class="bal_bar">
      <div id="balance" style="width:<?php echo $bal_width;?>%"></div>
      <div id="at_risk" style="width:<?php echo $ar_width;?>%"></div>
    </div>
  </div>
</div>