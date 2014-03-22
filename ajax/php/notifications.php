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

$notifs = $current_user->notifications;
?>

<span onclick="toggle_box()" class="icon-flag"> 
  <?php echo 
    count( $notifs )
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
          $n->desc;
        ?>
        <span>
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