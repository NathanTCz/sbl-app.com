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

    if ( $current_user->accept_request($bet_id) )
      ;
  }
  else if ($_POST['action'] == 'deny') {
    $bet_id = $_POST['b_id'];

    $current_user->deny_request($bet_id);
  }
}

$current_user->__construct($_SESSION['user']['email'],
                           $_SESSION['user']['u_name'],
                           $_SESSION['user_id']
                          );
$notifs = $current_user->notifications;
$n_cnt = count($notifs);

if ( $n_cnt > 0 ) {
?>
<span onclick="toggle_box()" class="icon-flag"> 
  <?php echo 
    $n_cnt
    ;
  ?>
</span>
<div id="notifications" 
  style="
      display:<?php echo $_GET['disp'];?>;
      opacity:<?php echo $_GET['opac'];?>
  ">
  <div class="tri"></div>

  <?php
  if ( !empty( $notifs ) ) {
    foreach ( $notifs as $n ) {
  ?>
    <span>
  <?php echo
      $n->title;
  ?>
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
        <span id="time">
          <?php echo
            $n->timestamp;
            ;
          ?>
        </span>
      </span>
    </span>
  <?php
    }
  }
  ?>

</div>
<?php
}
?>