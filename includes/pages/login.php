<div class="login_box">
  <div class="title">SBL</div>
  <form name="login" method="POST" action="/web/main#login">
    <span class="form_box">
      <span class="icon-user3"></span>
      <input type="text" name="email" placeholder="Email">
    </span>
    <span class="form_box">
      <span class="icon-lock"></span>
      <input type="password" name="password" placeholder="Password">
    </span>
    <button class="login_submit" type="submit" name="submit" value="login">
      <span>LOG IN</span>
      <span class="icon-arrow-up-right2"></span>
    </button>

    <span class="errors">
    <?php
    if (!empty($REG_ERRORS)) {
      foreach ($LOG_ERRORS as $error) {
        echo '*' . $error . '<br>';
      }
    }
    ?>
    </span>
    <div class="login_options">
      <span>Are you new here?</span>
      <a onclick="shift();"><u>Register</u></a>
      <span class="icon-arrow-right2"></span>
    </div>
  </form>
</div>
