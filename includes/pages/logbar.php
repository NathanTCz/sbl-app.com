<div class="user_bar">
  <form name ="logout" method ="POST" action ="/logout.php">
    <span><?php echo $current_user->get_email();?></span>
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
  <form name="profile" method="POST" action="/profile">
    <span>Profile</span>
      <button type="submit" name="profile">
      <span class="icon-profile"> </span>
    </button>
  </form>
</div>
