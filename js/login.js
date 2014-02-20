function check_pass() {
  var pass1 = document.getElementById("pass1").value;
  var pass2 = document.getElementById("pass2").value;
  var bg = document.getElementById("pass2").background;

  if (pass1 != pass2) {
    document.getElementById("pass2").style.background="ff0000";
    document.getElementById("l_submit").setAttribute("disabled", "true");
  }
  else if (pass1 == pass2) {
    document.getElementById("pass2").style.background="fff";
    document.getElementById("l_submit").removeAttribute("disabled");
  }
}

function check_hash() {
  if (window.location.hash) {
    if (window.location.hash == "#register") {
      shift();
      window.scrollTo(0,document.body.scrollHeight);
    }
  }
}

function shift() {
  document.getElementById('login').style.right = "100em";
}

function shift_back() {
  document.getElementById('login').removeAttribute('style');
  window.location.hash = null;
}


/*
THIS IS A WORKAROUND USING jQuery TO ACCOMPLISH SMOOTH SCROLLING
WE SHOULD FIND A WAY TO DO IT IN CSS
*/
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 600);
        return false;
      }
    }
  });
});

var zoomRatio = $(window).width() / 1600; 
//if your site is fixed at 1024 px for example

$(document).ready(function(){

$('html').css("zoom",zoomRatio);

});

$(window).resize(function(){
  var zoom = $(window).width() / 1600; 
  //if your site is fixed at 1024 px for example

  $('html').css("zoom",zoom);

  console.log(zoom);
})