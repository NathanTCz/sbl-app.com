/*setTimeout(function(){
  return set_width(<?php echo $bal_width;?>, <?php echo $ar_width;?>);
}, 200);*/

function set_width(b, a) {
  document.getElementById('balance').style.width = b + '%';
  document.getElementById('at_risk').style.width = a + '%';
}

function load_dash (id) {
  document.getElementById('dash_main').style.display = 'none';
  document.getElementById('loader').style.display = 'block';

  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    xmlHttp.onreadystatechange = function(){return process_dash(id)};
    
    xmlHttp.open("GET", "ajax/php/dashboard.php?action=" + id,true);
    xmlHttp.send();
  }

  // Change active item styling.
  var items = document.getElementsByClassName('dash_active');
  if (items.length > 0)
    items[0].removeAttribute('class');

  document.getElementById(id).className = 'dash_active';
}

function process_dash (id) {
  if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
    document.getElementById('loader').style.display = 'none';
    document.getElementById('dash_main').style.display = 'block';
    document.getElementById('dash_main').innerHTML=xmlHttp.responseText;

    if (id == 'bal') {
      var bw = document.getElementById('balance').getAttribute('data-width');
      var aw = document.getElementById('at_risk').getAttribute('data-width');

      setTimeout(
        function() {
          return set_width(bw, aw);
        },
        200
      );
    }
  }
}


// MAIN ROUTINE //
load_dash('bal');