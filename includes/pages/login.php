<div class="login_box">
  <div class="title">SBL</div>
  <form name="login" method="POST" action="/web/main#login">
    <span class="form_box">
      <span class="icon-user3"></span>
      <input type="text" name="email" placeholder="Username or Email">
    </span>
    <span class="form_box">
      <span class="icon-lock"></span>
      <input type="password" name="password" placeholder="Password">
    </span>
    <button class="login_submit" type="submit" name="login" value="login">
      <span>LOG IN</span>
      <span class="icon-arrow-up-right2"></span>
    </button>

    <?php
    if (!empty($LOG_ERRORS)) {
      echo '<span class="errors">';
      foreach ($LOG_ERRORS as $error) {
        echo '*' . $error . '<br>';
      }
      echo '</span>';
    }
    ?>
    <div class="login_options">
      <span>Are you new here?</span>
      <a href="#register"><u>Register</u></a>
      <span class="icon-arrow-right2"></span>
    </div>
  </form>
</div>
