<?php
/*
 * To add another nav button all you need to do is add it
 * to the array $nav_buttons. The key in the array is the
 * link that it points to and the value is the name of the
 * icon you want to use.
 *
 * EX|  if I wanted to add a settings button that brought me
 *      to the page '/settings', I would add:
 *
 *      'settings' => 'icon-cog'
 *
 *      to the array. Also don't forget commas. Simple as that.
*/

$nav_buttons = array('events' => 'icon-list2',
                     'dashboard' => 'icon-dashboard',
                     'live' => 'icon-feed'
                    );
?>

<div class="top_bar">
  <span class="title">SBL</span>
</div>

<div class="nav">
  <div class="nav_menu">
    <ul>
      <?php
      foreach ($nav_buttons as $link => $icon) {
        if (isset($_GET['page'])) {
          if ($_GET['page'] == $link) {
      ?>
      <a href="/<?php echo $link;?>">
        <li class="active">
          <br>
          <span class="<?php echo $icon;?>"></span>
          <div class="triangle"></div>
        </li>
      </a>
      <?php
          }
          else {
      ?>
      <a href="/<?php echo $link;?>">
        <li>
          <br>
          <span class="<?php echo $icon;?>"></span>
          <div class="triangle"></div>
        </li>
      </a>
      <?php
          }
        }
      }
      ?>
    </ul>
  </div>
</div>
