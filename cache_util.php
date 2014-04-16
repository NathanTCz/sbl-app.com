<?php
if($_GET['a'] == 'clear')
  apc_clear_cache();
if($_GET['a'] == 'info') {
  echo '<pre>';
  print_r(apc_cache_info());
  echo '</pre>';
}
?>