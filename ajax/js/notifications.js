//setTimeout(load_notifications, 100);

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
  setTimeout(load_notifications, 5000);

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = process_notifications;
    
    xmlHttp.open("GET", "ajax/php/notifications.php",true);
    xmlHttp.send();
    }
}

function process_notifications () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('user_tools').innerHTML=xmlHttp.responseText;
  }
}