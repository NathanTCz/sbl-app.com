//setTimeout(load_notifications, 10000);

function toggle_box () {
  var e = document.getElementById('notifications').style.opacity;

    if (e == 0) {
      document.getElementById('notifications').style.display = 'block'
      document.getElementById('notifications').style.opacity = '1';
    }
    if (e == 1) {
      document.getElementById('notifications').style.opacity = '0';

      setTimeout(function() {
          document.getElementById('notifications').style.display = 'none';
        }, 500);
    }
}

function load_notifications () {
  setTimeout(load_notifications, 10000);

  /* save the display style of the notfication box so that it
   * doesn't disappear every time. Send it with the GET data.
   */
  var display = document.getElementById('notifications').style.display;
  var opacity = document.getElementById('notifications').style.opacity;


  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = process_notifications;
    
    xmlHttp.open("GET", "ajax/php/notifications.php?disp=" + display + "&opac=" + opacity,false);
    xmlHttp.send();
  }
}

function process_notifications () {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
    document.getElementById('user_tools').innerHTML=xmlHttp.responseText;
  }
}

function accept_request (b_id) {
  var action = 'accept';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
    && xmlHttp.readyState != 3 ) {

  xmlHttp.onreadystatechange = process_notifications;
  
  xmlHttp.open("POST", "ajax/php/notifications.php", true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("b_id=" + encodeURIComponent(b_id) + 
               "&action=" + encodeURIComponent(action)
              );
  }
}

function deny_request (b_id) {
  var action = 'deny';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
    && xmlHttp.readyState != 3 ) {

  xmlHttp.onreadystatechange = process_notifications;
  
  xmlHttp.open("POST", "ajax/php/notifications.php", true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("b_id=" + encodeURIComponent(b_id) + 
               "&action=" + encodeURIComponent(action)
              );
  }
}