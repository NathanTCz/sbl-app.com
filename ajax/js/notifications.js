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
  //setTimeout(load_notifications, 10000);

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

  document.getElementById(b_id).style.display = 'none';
  document.getElementById('loader_small' + b_id).style.display = 'block';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
    && xmlHttp.readyState != 3 ) {

  xmlHttp.onreadystatechange = function() {
    return notif_success(b_id);
  };
  
  xmlHttp.open("POST", "ajax/php/notifications.php", true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("b_id=" + encodeURIComponent(b_id) + 
               "&action=" + encodeURIComponent(action)
              );
  }
}

function deny_request (b_id) {
  var action = 'deny';

  document.getElementById(b_id).style.display = 'none';
  document.getElementById('loader_small' + b_id).style.display = 'block';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
    && xmlHttp.readyState != 3 ) {

  xmlHttp.onreadystatechange = function() {
    return notif_success(b_id);
  };
  
  xmlHttp.open("POST", "ajax/php/notifications.php", true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("b_id=" + encodeURIComponent(b_id) + 
               "&action=" + encodeURIComponent(action)
              );
  }
}

function notif_success (b_id) {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
  document.getElementById('loader_small' + b_id).removeAttribute('style');

    // cant figure out why there are two spaces in front of the response
    // text, but fuck it
    if (xmlHttp.responseText == '  OK')
      document.getElementById('success_small' + b_id).style.display = 'block';

    else if (xmlHttp.responseText == '  ERROR')
      document.getElementById('error_small' + b_id).style.display = 'block';

    setTimeout(load_notifications, 500);
  }
}

/*
 * COUNTER OFFER LOGIC AND DOM MANIPULATION
*/

function show_counter_box (b_id) {
  /* beacuse the betbox is above the team info in the actual
   * HTML document we have to send that info to that element
   * with AJAX
   */
  load_counter_box(b_id);

  // Now we can display the element
  document.getElementById('bet_box').style.display = "block";

  document.getElementsByClassName('underlay')[0].style.zIndex = "99999";
  document.getElementsByClassName('underlay')[0].style.opacity = "0.7";

  document.getElementsByClassName('wrapper')[0].className = "wrapper blurred";
  //document.getElementsByClassName('main')[0].style.overflow = "hidden";
}

function load_counter_box (b_id) {

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = process_counter_box;
    
    xmlHttp.open("GET", "ajax/php/counter_box.php?b_id=" + b_id, true);
    xmlHttp.send();
    }
}

function process_counter_box () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('bet_box').innerHTML=xmlHttp.responseText;
  }
}

function counter_request (b_id, amt) {
  var action = 'counter';
  var amt = document.getElementById('ctr_amt').value;

  document.getElementById('bet_box').style.display = 'none';
  document.getElementById('spinner').style.color = '#FFF';
  document.getElementById('loader').style.display = 'block';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
    && xmlHttp.readyState != 3 ) {

  xmlHttp.onreadystatechange = counter_success;
  
  xmlHttp.open("POST", "ajax/php/notifications.php", true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("b_id=" + encodeURIComponent(b_id) + 
               "&amt=" + encodeURIComponent(amt) +
               "&action=" + encodeURIComponent(action)
              );
  }
}

function counter_success () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('bet_box').style.display = 'none';
    document.getElementById('loader').style.display = 'none';
    document.getElementById('spinner').removeAttribute('style');

    if (xmlHttp.responseText == '  OK')
      document.getElementById('success').style.display = 'block';

    else if ( xmlHttp.responseText == '  ERROR')
      document.getElementById('error').style.display = 'block';

    setTimeout(load_notifications, 500);
    setTimeout(hide, 1200);
  }
}