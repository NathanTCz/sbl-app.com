<?php
/* Move back to the server root dir so that
 * so that includes and such work correctly
 */
$root_dir = $_SERVER['DOCUMENT_ROOT'];
chdir($root_dir);

require_once 'core/init.php';

/* create current user object because we're outside the scope
 * of index.php which creates the current_user object
 */
if ($session->logged_in()) {
    $current_user = new User($_SESSION['user']['email'],
                             $_SESSION['user']['u_name'],
                             $_SESSION['user_id']
                            );
  }

if ( !empty($_POST) ) {
  if ($_POST['action'] == 'accept') {
    $bet_id = $_POST['b_id'];

    if ( $current_user->accept_request($bet_id) ) {
      echo 'OK';
      exit;
    }
    else {
      echo 'ERROR';
      exit;
    }
  }

  elseif ($_POST['action'] == 'deny') {
    $bet_id = $_POST['b_id'];

    $current_user->deny_request($bet_id);
    echo 'OK';
    exit;
  }

  elseif ($_POST['action'] == 'close') {
    $bet_id = $_POST['b_id'];

    $current_user->close_notif($bet_id);
    echo 'OK';
    exit;
  }

  elseif ($_POST['action'] == 'counter') {
    $bet_id = $_POST['b_id'];
    $amt = $_POST['amt'];

    if ( $current_user->counter_offer($bet_id, $amt) ) {
      echo 'OK';
      exit;
    }
    else {
      echo 'ERROR';
      exit;
    }
  }
}

$current_user->__construct($_SESSION['user']['email'],
                           $_SESSION['user']['u_name'],
                           $_SESSION['user_id']
                          );
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
<div id="notifications" 
  style="
      display:<?php echo $_GET['disp'];?>;
      opacity:<?php echo $_GET['opac'];?>
  ">
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