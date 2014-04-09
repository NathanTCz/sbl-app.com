<?php
  $notifs = $current_user->notifications;
  if ( !empty($notifs) ) {
    foreach ($notifs as $n) {
    ?>
      <div
        id="<?php echo $n->wager->id;?>"
        class="notif_list_item"
      >
        <span>
          <?php echo
            $n->title
            ;
          ?>
        </span>
        <span>
          <?php echo
            $n->desc
            ;
          ?>
        </span>
        <span>
          <?php echo
            $n->timestamp
            ;
          ?>
        </span>
        <span>
          <?php echo
            'view the event ' .
            '<a href="' .
            $n->wager->event->id .
            '">here</a>'
            ;
          ?>
        </span>
      </div>
    <?php
    }
  }
  else echo 'No new notifications';
?>