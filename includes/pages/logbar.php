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
      count( $current_user->get_pending_wagers() )
      ;
    ?>
  </span>
  <div id="notifications" style="display:none">
    <?php
    foreach ($current_user->get_pending_wagers() as $note)
      echo '<span>' .
      $SYSTEM->get_uname($note->opponent_id) .
      ' sent you a request' .
      '</span>'
      ;
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
