<div class="top_bar"></div>

<form id="top_form" class="top_form" name="login" method="POST" action="/web/main#login">
  <input type="text" name="email" placeholder="User or Email"/>
  <input type="password" name="password" placeholder="Password" onkeyup="check_enter(event)"/>
  <input type="hidden" name="login" value="login"/>
  <span class="icon-arrow-right2" onclick="submit_form()"></span>
</form>