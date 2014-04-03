function show_bet_box (h, a, e_id) {
  /* beacuse the betbox is above the team info in the actual
   * HTML document we have to send that info to that element
   * with AJAX
   */
  load_bet_box (h, a, e_id);

  // Now we can display the element
  document.getElementById('bet_box').style.display = "block";

  document.getElementsByClassName('underlay')[0].style.zIndex = "99999";
  document.getElementsByClassName('underlay')[0].style.opacity = "0.7";

  document.getElementsByClassName('wrapper')[0].className = "wrapper blurred";
}

function load_bet_box (h, a, e) {
  h = JSON.stringify(h);
  a = JSON.stringify(a);
  e = JSON.stringify(e);

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = process_bet_box;
    
    xmlHttp.open("POST", "ajax/php/betbox.php", true);
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send("home=" + encodeURIComponent(h) +
                 "&away=" + encodeURIComponent(a) +
                 "&event=" + encodeURIComponent(e)
                );
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
  //document.getElementsByClassName('main')[0].removeAttribute('style');

  document.getElementsByClassName('underlay')[0].style.zIndex = "0";
  document.getElementsByClassName('underlay')[0].style.opacity = "0";


  document.getElementById('success').style.display = 'none';
  document.getElementById('error').style.display = 'none';
}

function set_proposal (e, id) {
  if(j = document.getElementsByClassName('selected')[0])
    j.removeAttribute('class');

  e.className = "selected";

  document.getElementById('proposal').value = id;
}

function submit_request (e) {
  var prop = document.getElementById('proposal').value;
  var amnt = document.getElementById('amount').value;
  var opp = document.getElementById('opponent').value;
  //var e = document.getElementById('event').value;

  send_form_data (prop, amnt, opp, e);
}

function send_form_data (p, a, o, e) {
  var id = e.id;
  var time = e.timestamp;

  document.getElementById('bet_box').style.display = 'none';
  document.getElementById('spinner').style.color = '#FFF';
  document.getElementById('loader').style.display = 'block';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = success;
    
    xmlHttp.open("POST", "ajax/php/bet_action.php", true);
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send("prop=" + encodeURIComponent(p) + 
                 "&amnt=" + encodeURIComponent(a) +
                 "&opp=" + encodeURIComponent(o) +
                 "&e_id=" + encodeURIComponent(id) +
                 "&time=" + encodeURIComponent(time) 
                );
    }
}

function success () {
  if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
    document.getElementById('bet_box').style.display = 'none';
    document.getElementById('loader').style.display = 'none';
    document.getElementById('spinner').removeAttribute('style');

    if (xmlHttp.responseText == '  OK')
      document.getElementById('success').style.display = 'block';

    else if ( xmlHttp.responseText == '  ERROR')
      document.getElementById('error').style.display = 'block';

    setTimeout(hide, 1200);
  }
}