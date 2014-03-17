load_list(1);

function load_list (id) {
  document.getElementById('list').style.display = 'none';
  document.getElementById('loader').style.display = 'block';
  document.getElementById('event').style.display = 'none';
  document.getElementById('loader').style.display = 'block';

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = process_event_list;
    
    xmlHttp.open("GET", "ajax/php/event_list.php?cat=" + id,true);
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
  document.getElementById('loader').style.display = 'none';
  document.getElementById('list').style.display = 'none';
  document.getElementById('loader').style.display = 'block';

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

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

function show_bet_box () {
  document.getElementById('bet_box').style.display = "block";

  document.getElementsByClassName('wrapper')[0].className = "wrapper blurred";

  document.getElementsByClassName('underlay')[0].style.display = "block";
  document.getElementsByClassName('underlay')[0].style.opacity = "0.7";
}

function hide (e) {
  document.getElementById('bet_box').style.display = "none";

  document.getElementsByClassName('wrapper')[0].className = "wrapper";

  e.style.display = "none";

}