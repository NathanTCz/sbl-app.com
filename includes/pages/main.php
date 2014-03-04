<?php
  if ($session->logged_in()) {
    $session->redirect("/home");
    exit;
  }

  if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Create Login Object
    $login = new Login($email, $pass); 

    if ($user_id = $login->auth_user()) {
      $session->login($user_id);
    }
    else {
      $LOG_ERRORS[] = "Invalid Credentials";
    }
  }

  else if (isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password2']);

    // Create Login Object
    $login = new Login($email, $pass); 

    if ($login->register_user())
      $session->redirect("/web/regcomp");
  }
?>

<html id="top">
  <head>
    <title>SBL</title>
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>

    <script src="/js/jquery-1.11.0.min.js"></script>
    <script src="/js/login.js"></script>
  </head>

  <body onload="check_hash()" onhashchange="check_hash()">

    <div class="scrollbar">
      <a id="top" href="#top">
        <span class="icon-arrow-up2"></span>
      </a>
      <a id="login1" href="#login">
        <span class="icon-arrow-down2"></span>
      </a>
    </div>

    <div id="arrow" class="arrow">
      <span onclick="shift_back()" class="icon-arrow-left2"></span>
    </div>

    <?php
    include 'includes/pages/topbar.php';
    ?>

    <div class="main">
    <div id="back1" class="background"></div>
    <div id="back2" class="background"></div>

      <section id="about">
        <div class="logo">
          <span>SBL</span>
        </div>

        <div class="desc">
          <h1>Sports Betting League</h1>
          <span>
          The Sports Betting League is an online sports betting platform. Sports fans from all over can come
          to place bets on various sports events. Challenge your friends, coworkers, family, anyone to a bet or
          place a public bet on anything imaginable.
          </span>
        </div>

        <div class="info">
          <div class="attr">
            <span class="icon icon-newspaper"></span>
            <br>
            <span>
            <h2>-Up to date events</h2>
            SBL stays up to date with the latest events in professional
            and collegiate sports, giving you the opportunity to put your
            credits on the line.
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-stack"></span>
            <br>
            <span>
            <h2>-Immediate benefits when you join</h2>            
            We give you 100 tokens to start testing your skill
            and luck, right when you login.
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-ticket"></span>
            <br>
            <span>
            <h2>-Customized events</h2>
            SBL allows you to submit your own events so you can bet 
            on your son's little league game, or your friend's beer
            pong tournament. 
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-coin"></span>
            <br>
            <span>
            <h2>-Show everyone your worth</h2>
            Let everyone know you're in it to win it by putting it 
            all on the line.
            </span>
          </div>
        </div>
      </section>

      <section id="login">

        <?php
        include 'includes/pages/login.php';
        include 'includes/pages/register.php';
        ?>
      </section>

    </div>
  </body>
</html>
