<div class="register_box">
  <div class="title">SBL</div>
  <form name="login" method="POST" action="/web/main#register">
    <span class="form_box">
      <span class="icon-user3"></span>
      <input type="text" name="email" placeholder="Email">
    </span>
    <span class="form_box">
      <span class="icon-lock"></span>
      <input id="pass1" type="password" name="password1" placeholder="Password">
    </span>
    <span class="form_box">
      <span class="icon-lock"></span>
      <input onkeyup="check_pass()" id="pass2" type="password" name="password2" placeholder="Password again please">
    </span>
    <button id="l_submit" class="login_submit" type="submit" name="register" value="register" disabled>
      <span>REGISTER</span>
      <span class="icon-arrow-up-right2"></span>
    </button>

    <span class="errors">
    <?php
    if (!empty($REG_ERRORS)) {
      foreach ($REG_ERRORS as $error) {
        echo '*' . $error. '<br>';
      }
    }
    ?>
    </span>
  </form>
</div>