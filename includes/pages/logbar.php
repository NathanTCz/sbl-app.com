<div class="user_bar">
  <form name ="logout" method ="POST" action ="/logout.php">
    <span><?php echo $current_user->get_uname();?></span>
    <button type="submit" name="logout">
      <span class="icon-switch">
        &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        LOGOUT
      </span>
    </button>
  </form>
</div>

<div class="user_tools">
  <span onclick="toggle_box()" class="icon-flag"> 
    <?php echo 
      count( $current_user->get_notifications() )
      ;
    ?>
  </span>
  <div id="notifications" style="display:none;">
    <div class="tri"></div>

    <?php
    $n = $current_user->get_notifications();

    if ( !empty( $n['requests'] ) ) {
      foreach ( $n['requests'] as $r )
    ?>
      <span>
    <?php echo
        '<b>' . $SYSTEM->get_uname($r->user_id) . '</b>' .
        ' sent you a request'
        ;
    ?>
        <span>
          <?php
            echo
            $SYSTEM->get_uname($r->user_id) .
            ' put ' .
            $r->amount .
            ' on '
            ;
            if ($r->proposal == $r->event->home_team->id)
              echo $r->event->home_team->short_name;
            
          ?>
          <span>
            <?php echo
              $r->timestamp
              ;
            ?>
          </span>
        </span>
      </span>
    <?php
    }

    if ( !empty( $n['accepted'] ) ) {
      foreach ( $n['accepted'] as $a )
    ?>
      <span>
    <?php echo
        '<b>' . $SYSTEM->get_uname($a->opponent_id) . '</b>' .
        ' accepted your request'
        ;
    ?>
        <span>
          <?php
            echo
            'You put ' .
            $a->amount .
            ' on '
            ;
            if ($a->proposal == $a->event->home_team->id)
              echo $a->event->home_team->short_name;
            else
              echo $a->event->away_team->short_name;
            
          ?>
          <span>
            <?php echo
              $a->timestamp
              ;
            ?>
          </span>
        </span>
      </span>
    <?php
    }

    if ( !empty( $n['denied'] ) ) {
      foreach ( $n['denied'] as $d )
    ?>
      <span>
    <?php echo
        '<b>' . $SYSTEM->get_uname($d->opponent_id) . '</b>' .
        ' denied your request'
        ;
    ?>
        <span>
          <?php
            echo
            'You put ' .
            $d->amount .
            ' on '
            ;
            if ($d->proposal == $d->event->home_team->id)
              echo $d->event->home_team->short_name;
            else
              echo $d->event->away_team->short_name;
            
          ?>
          <span>
            <?php echo
              $d->timestamp
              ;
            ?>
          </span>
        </span>
      </span>
    <?php
    }
    ?>

  </div>
</div>

<script src="ajax/js/notifications.js"></script>
