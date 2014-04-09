<?php
$balance = $current_user->yac->balance;
$at_risk = $current_user->yac->at_risk;

$bal_width = ( $balance / ($balance + $at_risk) * 100 );
$ar_width = ( $at_risk / ($balance + $at_risk) * 100 );

//$ar_top = $balance / ($balance + $at_risk) * 10;
//$bal_top = $at_risk / ($balance + $at_risk) * 10;

$bets_navs = array('Recent' => 'rec',
                   'Counters' => 'cnt',
                   'Pending' => 'pen',
                   'Accepted' => 'acc',
                   'Denied' => 'den',
                  );
?>

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
  <div id="balance" data-width="<?php echo $bal_width;?>"></div>
  <div id="mid_bar"></div>
  <div id="at_risk" data-width="<?php echo $ar_width;?>"></div>
</div>

<div class="rec_bets">
  <div class="bets_nav">
    <?php
    foreach ($bets_navs as $name => $action) {
    ?>
    <span
      id="<?php echo $action;?>"
      onclick="load_bets_view(this.id)"
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
  <div id="bets_view" class="bets_view"></div>
</div>