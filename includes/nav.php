<?php
  $eventsClassName = '';
  $betsClassName = '';
  $liveClassName = '';

  if (isset($_GET['page'])) {
    if ($_GET['page'] === "events") {
      $eventsClassName = "active";
    }

    else if ($_GET['page'] === "bets") {
      $betsClassName = "active";
    }

    else if ($_GET['page'] === "live") {
      $liveClassName = "active";
    }
  }
  else {
    $_GET['page'] = "events";
    $eventsClassName = "active";
  }
?>
<div class="top_bar">
  <span class="title">SBL</span>
</div>

<div class="nav">
  <div class="nav_menu">
    <ul>
      <a href="/events">
        <li class="<?php echo $eventsClassName;?>">
          <br>
          <span class="icon-list2"></span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/bets">
        <li class="<?php echo $betsClassName;?>">
          <br>
          <span class="icon-ticket"></span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/live">
        <li class="<?php echo $liveClassName;?>">
          <br>
          <span class="icon-feed"></span>
          <div class="triangle"></div>
        </li>
      </a>
    </ul>
  </div>
</div>
