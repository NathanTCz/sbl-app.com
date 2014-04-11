function check_pass() {
  var pass1 = document.getElementById("pass1").value;
  var pass2 = document.getElementById("pass2").value;

  if (pass1 != pass2) {
    document.getElementById("pass2").style.background="ED4337";
    document.getElementById("l_submit").setAttribute("disabled", "true");
  }
  else if (pass1 == pass2) {
    document.getElementById("pass2").style.background="fff";
    document.getElementById("l_submit").removeAttribute("disabled");
  }
}

function check_enter(e) {
  var key = e.keyCode;

  if (key == 13)
    submit_form();
}

function submit_form() {
  document.getElementById('top_form').submit();
}

function check_hash() {
  if (window.location.hash) {
    if (window.location.hash == "#register") {
      shift();
      window.scrollTo(0,document.body.scrollHeight);
    }
  }
}

/*
This function is for cross-browser compatibility.
each browser has a different name for the 'transitionEnd'
event
*/
function find_browser_event() {
    var t;
    var el = document.createElement('fakeelement');
    var transitions = {
      'transition':'transitionend',
      'OTransition':'oTransitionEnd',
      'MozTransition':'transitionend',
      'WebkitTransition':'webkitTransitionEnd'
    }

    for(t in transitions){
        if( el.style[t] !== undefined ){
            return transitions[t];
        }
    }
}

function shift() {
  var box = document.getElementById('login')
  box.className = "animated";
  console.log(box);
  var t_event = find_browser_event();

  /*
  Don't show the arrow to go back until the box
  is finished moving.
  */
  box.addEventListener( 
   t_event, 
   function( event ) {
      if (box.className == "animated")
        document.getElementById('arrow').style.opacity = "1";
   }, false );
}

function shift_back() {
  document.getElementById('login').removeAttribute('class');
  document.getElementById('arrow').removeAttribute('style');
  window.location.hash = 'login';
}


/*
THIS IS A WORKAROUND USING jQuery TO ACCOMPLISH SMOOTH SCROLLING
WE SHOULD FIND A WAY TO DO IT IN CSS


UPDATE:
This might be the best option, without reworking the whole
structure of the document.
*/
$(function() {
  $('a[href*=#]:not([href=#register])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
          || location.hostname == this.hostname) {

          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
             if (target.length) {
               $('html,body').animate({
                   scrollTop: target.offset().top
              }, 900);
              return false;
          }
      }
  });
});

/*var zoomRatio = $(window).width() / 1600; 

$(document).ready(function(){

$('html').css("zoom",zoomRatio);

});

$(window).resize(function(){
  var zoom = $(window).width() / 1600;

  $('html').css("zoom",zoom);

  console.log(zoom);
})*/