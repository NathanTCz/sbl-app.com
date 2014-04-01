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
else
  exit;

$balance = $current_user->yac->balance;
$at_risk = $current_user->yac->at_risk;

$bal_width = $balance / ($balance + $at_risk) * 100;
$ar_width = $at_risk / ($balance + $at_risk) * 100;

//$ar_top = $balance / ($balance + $at_risk) * 10;
//$bal_top = $at_risk / ($balance + $at_risk) * 10;

if ($_GET['action'] == 'bal') {
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
  <div id="at_risk" data-width="<?php echo $ar_width;?>"></div>
</div>
<?php
}
elseif ($_GET['action'] == 'notifs') {
  $notifs = $current_user->notifications;
  if ( !empty($notifs) ) {
    foreach ($notifs as $n) {
    ?>
    <span>
      <?php echo
        $n->title
        ;
      ?>
    </span>
    <?php
    }
  }
  else echo 'No new notifications';
}
?>