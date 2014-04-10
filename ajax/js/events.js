var current_cat = 0;
var key_int;
load_list(1, '');

function load_list (id, q) {
  current_cat = id;

  document.getElementById('list').style.display = 'none';
  document.getElementById('search').style.display = 'block';
  document.getElementById('loader').style.display = 'block';
  document.getElementById('event').style.display = 'none';

// there are some issues of previous requests blocking this request
// on every keyup event
  if (
      //true
      (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 
      )
  {
    xmlHttp.onreadystatechange = process_event_list;
    
    xmlHttp.open("GET", "ajax/php/event_list.php?cat=" + current_cat + "&q=" + q,true);
    xmlHttp.send();
  }

  // Change active item styling.
  var items = document.getElementsByClassName('cat_active');
  if (items.length > 0)
    items[0].removeAttribute('class');

  document.getElementById(id).className = 'cat_active';
}

function process_event_list () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('loader').style.display = 'none';
    document.getElementById('list').style.display = 'block';
    document.getElementById('list').innerHTML=xmlHttp.responseText;
  }
}

function load_event (id, cat) {
  document.getElementById('event').style.display = 'none';
  document.getElementById('loader').style.display = 'block';
  document.getElementById('list').style.display = 'none';
  document.getElementById('search').style.display = 'none';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = process_event_page;
    
    xmlHttp.open("GET", "ajax/php/event_det.php?cat=" + cat + "&event_id=" + id,true);
    xmlHttp.send();
    }
}

function process_event_page () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('loader').style.display = 'none';
    document.getElementById('event').style.display = 'block';
    document.getElementById('event').innerHTML=xmlHttp.responseText;
  }
}

function search (q) {
  clearTimeout(key_int);
  key_int = setTimeout( function(){return load_list(current_cat, q)}, 800);
}