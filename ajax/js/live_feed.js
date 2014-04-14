setTimeout(function(){return load_live_feed(0)}, 1000);

function load_live_feed (ts) {
  if ( (xmlHttp.readyState == 0 || xmlHttp.readyState == 4)
      && xmlHttp.readyState != 3 ) {

    console.log(ts);

    xmlHttp.onreadystatechange = process_live_feed;
    
    xmlHttp.open("GET", "ajax/php/live_feed.php?ts=" + ts,true);
    xmlHttp.send();
  }
}

function process_live_feed () {
  if (
     xmlHttp.readyState == 4
     && xmlHttp.status == 200
     )
  {
    var response = JSON.parse(xmlHttp.responseText);

    document.getElementById('live').innerHTML += response.data;

    setTimeout(function(){return load_live_feed(response.new_ts)}, 500);
  }
}