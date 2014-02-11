<script>
function check_pass() {
  var pass1 = document.getElementById("pass1").value;
  var pass2 = document.getElementById("pass2").value;
  var bg = document.getElementById("pass2").background;

  if (pass1 != pass2) {
    document.getElementById("pass2").style.background="ff0000";
    document.getElementById("l_submit").setAttribute("disabled", "true");
  }
  else if (pass1 == pass2) {
    document.getElementById("pass2").style.background="fff";
    document.getElementById("l_submit").removeAttribute("disabled");
  }
}
</script>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
  </head>
<body>
<div class="background">
</div>
<div class="register_box">
  <div class="title">SBL</div>
  <form name="login" method="POST" action="/web/register">
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
    <button id="l_submit" class="login_submit" type="submit" name="submit" disabled>
      <span>REGISTER</span>
      <span class="icon-arrow-up-right2"></span>
    </button>

    <span class="errors">
    <?php
    if (!empty($ERRORS)) {
      foreach ($ERRORS as $error) {
        echo $error;
      }
    }
    ?>
    </span>
  </form>
</div>
</body>
