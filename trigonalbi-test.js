// Global variables 
var countTriBi=0; // counts for lone pair additions
var atom;
var anglesTriBi = [90,135,225,270,0]; // angles for circles (to add lone pair) 

// clear content in molecule

function clearBoxesTrigonalbiTest() {
  var res = {};
  var x = document.querySelectorAll(".dropBox");
  for (i = 0; i < x.length; i++) {
    x[i].innerHTML = ""; // clear boxes
    x[i].style.backgroundColor = ""; // clear box highlights
    x[i].style.visibility = "visible"; // clear previous box hide
    console.clear();
  }
  var icons = document.querySelectorAll(".atom");
  for (var i = 0; i < icons.length; i++) {
    icons[i].style.backgroundColor = ""; // clear previous atom highlight
  }
  
  var eboxes = document.querySelectorAll(".e-box");
  for (var i = 0; i < eboxes.length; i++) {
    eboxes[i].innerHTML = ""; // clear previous atom highlight
  }

  var bonds = document.querySelectorAll(".bond");
  for (var i = 0; i < bonds.length; i++) {
    bonds[i].style.visibility = "visible"; // clear previous bond hidden
  }

  document.getElementById("bond1-trigonalbi-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";
  document.getElementById("bond4-trigonalbi-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";

  ctxTriBi1.clearRect(0, 0, cTriBi1.width, cTriBi1.height);
  ctxTriBi2.clearRect(0, 0, cTriBi2.width, cTriBi2.height);
  ctxTriBi3.clearRect(0, 0, cTriBi3.width, cTriBi3.height);
  ctxTriBi4.clearRect(0, 0, cTriBi4.width, cTriBi4.height);
  ctxTriBi5.clearRect(0, 0, cTriBi5.width, cTriBi5.height);
  ctxTriBi6.clearRect(0, 0, cTriBi6.width, cTriBi6.height);
  ctxTriBi.clearRect(0, 0, cTriBi7.width, cTriBi7.height);
  countTriBi=alphaTriBi=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
  drawCircleTriBi();
}

/*
called when submit button is clicked
*/

function submitAnswerTrigonalbiTest() { 
  res["molecule"]=mol;
  res["ePairs"]=countTriBi;
  var boxes = document.querySelectorAll(".trigonalbi-box");
  for (var i = 0; i < boxes.length; i++) {
    var b = boxes[i].innerHTML;
    if (res[b] == null) {
        res[b]=1;
      }
    else {
      res[b]=res[b]+1;
    }
  }
  var fb = document.getElementById("feedback");
  
  if (isEquivalentTriBihedral(n, res) && selectedCorr==selected) {
    fb.innerHTML = "Correct!";
  }
  
  else {
    fb.innerHTML = "Incorrect";
  }

}


// electron circles

//Define Variables
var radius = 22;
var point_size = 2;
var center_x = 35;
var center_y = 34;
var font_size = "15px";

var radius1 = 30;
var point_size1 = 2;
var center_x1 = 35;
var center_y1 = 34;
var font_size1 = "15px";

var cTriBi1 = document.getElementById("CanvasTriBi1");
var cTriBi2 = document.getElementById("CanvasTriBi2");
var cTriBi3 = document.getElementById("CanvasTriBi3");
var cTriBi4 = document.getElementById("CanvasTriBi4");
var cTriBi5 = document.getElementById("CanvasTriBi5");
var cTriBi6 = document.getElementById("CanvasTriBi6");
var cTriBi = document.getElementById("CanvasTriBi");

var ctxTriBi1 = cTriBi1.getContext("2d");
var ctxTriBi2 = cTriBi2.getContext("2d");
var ctxTriBi3 = cTriBi3.getContext("2d");
var ctxTriBi4 = cTriBi4.getContext("2d");
var ctxTriBi5 = cTriBi5.getContext("2d");
var ctxTriBi6 = cTriBi6.getContext("2d");
var ctxTriBi = cTriBi.getContext("2d");
ctxTriBi1.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi2.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi3.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi4.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi5.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi6.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTriBi.strokeStyle = 'rgba(0,0,0,0)';

function drawCircleTriBi(){
  ctxTriBi1.beginPath();
  ctxTriBi1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi1.stroke();

  ctxTriBi2.beginPath();
  ctxTriBi2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi2.stroke();

  ctxTriBi3.beginPath();
  ctxTriBi3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi3.stroke();

  ctxTriBi4.beginPath();
  ctxTriBi4.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi4.stroke();

  ctxTriBi5.beginPath();
  ctxTriBi5.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi5.stroke();

  ctxTriBi6.beginPath();
  ctxTriBi6.arc(center_x, center_y, radius, 0, 2 * Math.PI);
  ctxTriBi6.stroke();

  ctxTriBi.beginPath();
  ctxTriBi.arc(center_x1, center_y1, radius1, 0, 2 * Math.PI);
  ctxTriBi.stroke(); 
}

function drawPoint(c,angle,distance,label){
    var x = center_x + radius * Math.cos(-angle*Math.PI/180) * distance;
    var y = center_y + radius * Math.sin(-angle*Math.PI/180) * distance;

    c.beginPath();
    c.arc(x, y, point_size, 0, 2 * Math.PI);
    c.fill();

    c.font = font_size;
    c.fillText(label,x + 10,y);
}

//Execution
drawCircleTriBi();

function addPoints(alpha, canvas) {
  drawPoint(canvas,alpha+7,1,"");
  drawPoint(canvas,alpha-7,1,"");
}


/*
check is structures match
*/

function isEquivalentTrigonalbi(a, b) {
    // Create arrays of property names
    var aProps = Object.getOwnPropertyNames(a);
    var bProps = Object.getOwnPropertyNames(b);

    // If number of properties is different,
    // objects are not equivalent
    if (aProps.length != bProps.length) {
        return false;
    }

    for (var i = 0; i < aProps.length; i++) {
        var propName = aProps[i];

        // If values of same property are not equal,
        // objects are not equivalent
        if (a[propName] !== b[propName]) {
            return false;
        }
    }

    // If we made it this far, objects
    // are considered equivalent
    return true;
    
}

function changeImageTriBi(element) {
  var s = element.src;
  var srcs = ["https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/double-2.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/triple-2.png"];
  var i = srcs.indexOf(s);
  if (i<2) {
  element.src=srcs[i+1];
  } 
  else {
    element.src=srcs[0]; 
  }
}
