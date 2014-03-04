load_list(1);

function load_list (id) {
  document.getElementById('loader').style.display = 'block';

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = process_server_response;
    
    xmlHttp.open("GET", "ajax/php/event_list.php?cat=" + id,true);
    xmlHttp.send();
    }

  // Change active item styling.
  var items = document.getElementsByClassName('cat_active');
  if (items.length > 0)
    items[0].removeAttribute('class');

  document.getElementById(id).className = 'cat_active';
}

function process_server_response () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('list').innerHTML=xmlHttp.responseText;
  }
}