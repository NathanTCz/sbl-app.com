<?php
// Sort helper function
function compare_notification ($a, $b) {
  $a_time = strtotime($a->timestamp);
  $b_time = strtotime($b->timestamp);

  if ($a_time == $b_time)
    return 0;

  return ($a_time > $b_time) ? -1 : 1;
}

  $notifs = $current_user->notifications;
  usort($notifs, 'compare_notification');

  $n_cnt = count($notifs);

  if ( $n_cnt == 0 )
    $back = '#444';
  else
    $back = '#ADFF2F';
?>

<div id="user_tools" class="user_tools">
  <span class="user_name">
    <?php echo
      $current_user->get_uname()
      ;
    ?>
  </span>
  <span class="top_bal">
    <span>
      <?php echo
        $current_user->yac->balance
        ;
      ?>
    </span>
    <span> | </span>
    <span>
      <?php echo
        $current_user->yac->at_risk
        ;
      ?>
    </span>
  </span>
  <span onclick="toggle_box()" class="notif_box"> 
    <span class="circle" style="background:<?php echo $back;?>"></span>
  </span>
  <span onclick="location.href='/logout.php'" class="logout_btn"> 
    <span class="icon-switch"></span>
  </span>
<?php
if ( $n_cnt > 0 ) {
?>
<div id="notifications" style="display:none; opacity:0;">
  <div class="tri"></div>

  <?php
  if ( !empty( $notifs ) ) {
    foreach ( $notifs as $n ) {
      if ( $n->type == 'request' ) {
    ?>
      <div id="loader_small<?php echo $n->wager->id;?>"
        class="loader_small"
      >
        <span class="icon-spinner2"></span>
      </div>
      <div id="success_small<?php echo $n->wager->id;?>"
        class="success_small"
      >
        <span class="icon-checkmark-circle"></span>
      </div>
      <div id="error_small<?php echo $n->wager->id;?>"
        class="error_small"
      >
        <span class="icon-cancel-circle"></span>
      </div>

      <span id="<?php echo $n->wager->id;?>">
        <span id="notif_title">
          <?php echo
            $n->title;
          ?>
          <span class="icon-close"
                id="close" 
                onclick="close_notif(<?php echo $n->wager->id;?>)"
          >
          </span>
        </span>
        <span>
          <?php echo
            $n->desc . '<br><br>';
          ?>
          <span
            id="acc_den"
            onclick="accept_request(<?php echo $n->wager->id;?>)"
          >Accept
          </span>
          <span
            id="acc_den"
            onclick="deny_request(<?php echo $n->wager->id;?>)"
          >Deny
          </span>
          <span
            id="acc_den"
            onclick="show_counter_box(<?php echo $n->wager->id;?>)"
          >Counter
          </span>
          <span id="time">
            <?php echo
              $n->timestamp
              ;
            ?>
          </span>
        </span>
      </span>
    <?php
      }
      elseif ( $n->type == 'message' ) {
      ?>
        <div id="loader_small<?php echo $n->wager->id;?>"
        class="loader_small"
      >
        <span class="icon-spinner2"></span>
      </div>
      <div id="success_small<?php echo $n->wager->id;?>"
        class="success_small"
      >
        <span class="icon-checkmark-circle"></span>
      </div>
      <div id="error_small<?php echo $n->wager->id;?>"
        class="error_small"
      >
        <span class="icon-cancel-circle"></span>
      </div>

      <span id="<?php echo $n->wager->id;?>">
        <span id="notif_title">
          <?php echo
            $n->title;
          ?>
          <span class="icon-close"
                id="close" 
                onclick="close_notif(<?php echo $n->wager->id;?>)"
          >
          </span>
        </span>
        <span>
          <?php echo
            $n->desc . '<br><br>';
          ?>
          <span id="time">
            <?php echo
              $n->timestamp
              ;
            ?>
          </span>
        </span>
      </span>
      <?php
      }
    }
  ?>
    <span id="see_all">See all notifications</span>
  <?php
  }
  ?>

</div>
<?php
}
?>
</div>

<script src="ajax/js/notifications.js"></script>
