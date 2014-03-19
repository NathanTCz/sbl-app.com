<div id="bet_box" class="bet_box"></div>

<script>
function set_proposal (e, id) {
  if(j = document.getElementsByClassName('selected')[0])
    j.removeAttribute('class');

  e.className = "selected";

  document.getElementById('proposal').value = id;
}
</script>