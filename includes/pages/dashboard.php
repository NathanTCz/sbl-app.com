<?php
$dash_navs = array('Balance' => 'bal',
                   'Notifications' => 'notifs'
                  );
?>

<div class="dash">
  <div class="dash_nav">
    <?php
    foreach ($dash_navs as $name => $action) {
    ?>
    <span
      id="<?php echo $action;?>"
      onclick="load_dash(this.id)"
    >
      <?php echo
        $name
        ;
      ?>
    </span>
    <?php
    }
    ?>
  </div>
  <div id="dash_main" class="dash_main"></div>
</div>
<script src="ajax/js/dashboard.js"></script>