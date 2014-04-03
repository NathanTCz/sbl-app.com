<div class="counter_box">
  <span id="ctr_title">Enter Counter Offer</span>

  <div id="amt">
    <span class="icon-coin"></span>
    <input id="ctr_amt" type="number"/>
  </div>

  <div class="btns">
    <span id="ctr_cancel" onclick="hide()">Cancel</span>
    <span id="ctr_send" onclick="counter_request(<?php echo $_GET['b_id'];?>)">Send Counter Offer</span>
  </div>
</div>