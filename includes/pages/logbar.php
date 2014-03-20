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

<div class="user_tools">
  <span onclick="toggle_box()" class="icon-flag"> 
    <?php echo 
      count( $current_user->get_notifications() )
      ;
    ?>
  </span>
  <div id="notifications" style="display:none">
    <?php
    $n = $current_user->get_notifications();
    if ( !empty( $n['requests'] ) ) {
      foreach ( $n['requests'] as $r )
        echo '<span>' .
        $SYSTEM->get_uname($r->user_id) .
        ' sent you a request' .
        '</span>'
        ;
    }

    if ( !empty( $n['accepted'] ) ) {
      foreach ( $n['accepted'] as $a )
        echo '<span>' .
        $SYSTEM->get_uname($a->user_id) .
        ' accepted your request' .
        '</span>'
        ;
    }

    if ( !empty( $n['denied'] ) ) {
      foreach ( $n['denied'] as $d )
        echo '<span>' .
        $SYSTEM->get_uname($d->opponent_id) .
        ' denied your request' .
        '</span>'
        ;
    }
    ?>
  </div>
</div>

<script>
function toggle_box () {
  var e = document.getElementById('notifications').style.display;

    if (e == 'none')
      document.getElementById('notifications').style.display = 'block';
    if (e == 'block')
      document.getElementById('notifications').style.display = 'none';
}
</script>
