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

function show_bet_box (h, a) {
  /* beacuse the betbox is above the team info in the actual
   * HTML document we have to send that info to that element
   * with AJAX
   */
  load_bet_box (h, a);

  // Now we can display the element
  document.getElementById('bet_box').style.display = "block";

  document.getElementsByClassName('wrapper')[0].className = "wrapper blurred";

  document.getElementsByClassName('underlay')[0].style.display = "block";
}

function load_bet_box (h, a) {
  h = JSON.stringify(h);
  a = JSON.stringify(a);

  xmlHttp=new XMLHttpRequest();

  if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

    xmlHttp.onreadystatechange = process_bet_box;
    
    xmlHttp.open("POST", "ajax/php/betbox.php", true);
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send("home=" + encodeURIComponent(h) + "&away=" + encodeURIComponent(a));
    }
}

function process_bet_box () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('bet_box').innerHTML=xmlHttp.responseText;
  }
}

function hide () {
  document.getElementById('bet_box').style.display = "none";

  document.getElementsByClassName('wrapper')[0].className = "wrapper";

  document.getElementsByClassName('underlay')[0].style.display = "none";

}