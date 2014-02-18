<html>
  <head>
    <title>SBL</title>
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>
  </head>

  <body onscroll="shift_back()">
    <div id="back1" class="background"></div>
    <div id="back2" class="background"></div>

    <div class="scrollbar">
      <a id="about1" href="#about">
        <span class="icon-arrow-up2"></span>
      </a>
      <a id="login1" href="#login">
        <span class="icon-arrow-down2"></span>
      </a>
    </div>

    <div class="main">

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
            &nbsp;
            SBL stays up to date with the latest events in professional
            and collegiate sports, giving you the opportunity to bet on a
            multitude of sports events.
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-stack"></span>
            <br>
            <span>
            <h2>-Rack up Stacks</h2>
            &nbsp;
            SBL stays up to date with the latest events in professional
            and collegiate sports, giving you the opportunity to bet on a
            multitude of sports events.
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-ticket"></span>
            <br>
            <span>
            <h2>-Another great thing</h2>
            &nbsp;
            SBL stays up to date with the latest events in professional
            and collegiate sports, giving you the opportunity to bet on a
            multitude of sports events.
            </span>
          </div>

          <div class="attr">
            <span class="icon icon-coin"></span>
            <br>
            <span>
            <h2>-Score that cheese</h2>
            &nbsp;
            SBL stays up to date with the latest events in professional
            and collegiate sports, giving you the opportunity to bet on a
            multitude of sports events.
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