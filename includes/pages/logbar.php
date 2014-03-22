<?php
 $notifs = $current_user->notifications;
?>

<div class="user_bar">
  <form name ="logout" method ="POST" action ="/logout.php">
    <span><?php echo $current_user->get_uname();?></span>
    <button type="submit" name="logout">
      <span class="icon-switch">
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        LOGOUT
      </span>
    </button>
  </form>
</div>

<div id="user_tools" class="user_tools">
<span onclick="toggle_box()" class="icon-flag"> 
  <?php echo 
    count( $notifs )
    ;
  ?>
</span>
<div id="notifications" style="display:none; opacity:0;">
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
</div>

<script src="ajax/js/notifications.js"></script>
