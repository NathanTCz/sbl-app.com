<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
  </head>
<body>
<div class="background">
</div>
<div class="login_box">
  <div class="title">SBL</div>
  <form name="login" method="POST" action="/web/login">
    <span class="form_box">
      <span class="icon-user3"></span>
      <input type="text" name="email" placeholder="Email">
    </span>
    <span class="form_box">
      <span class="icon-lock"></span>
      <input type="password" name="password" placeholder="Password">
    </span>
    <button class="login_submit" type="submit" name="submit">
      <span>LOG IN</span>
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
    <div class="login_options">
      <span>Are you new here?</span>
      <a href="/web/register"><u>Register</u></a>
      <span class="icon-arrow-right2"></span>
    </div>
  </form>
</div>
</body>
