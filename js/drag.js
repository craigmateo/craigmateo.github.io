var toppx=100;
var leftpx=20;

//Make the DIV element draggagle:
$( document ).ready(function() {
    $('.dragdiv').hover(function(event){
    if (event.target.id.includes("dragdivheader")) {
        let targetid = event.target.id.replace("dragdivheader", "dragdiv");
        dragElement(document.getElementById(targetid));
    }
    });
});

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id)) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById(elmnt.id).onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    target = e.target.id;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    toppx = (elmnt.offsetTop - pos2);
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    leftpx = (elmnt.offsetLeft - pos1);
    //console.log(elmnt.style.top);
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
  }
}