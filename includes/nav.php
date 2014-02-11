<?php
  $homeClassName = '';
  $betsClassName = '';
  $liveClassName = '';

  if (isset($_GET['page'])) {
    if ($_GET['page'] === "home") {
      $homeClassName = "active";
    }

    else if ($_GET['page'] === "bets") {
      $betsClassName = "active";
    }

    else if ($_GET['page'] === "live") {
      $liveClassName = "active";
    }
  }
  else {
    $_GET['page'] = "home";
    $homeClassName = "active";
  }
?>

<div class="nav">
  <span class="title">SBL</span>
  <div class="nav_menu">
    <ul>
      <a href="/home">
        <li class="<?php echo $homeClassName;?>">
          <br>
          <span>Home</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/bets">
        <li class="<?php echo $betsClassName;?>">
          <br>
          <span>Bets</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/live">
        <li class="<?php echo $liveClassName;?>">
          <br>
          <span>Live</span>
          <div class="triangle"></div>
        </li>
      </a>
    </ul>
  </div>
</div>
