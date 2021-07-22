// Global variables 
var countOcta=0; // counts for lone pair additions
var atom;
var anglesOcta = [90,135,225,270,-45,45]; // angles for circles (to add lone pair) 

// clear content in molecule

function clearBoxesOctahedralTest() {
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

  document.getElementById("bond1-octahedral-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";
  document.getElementById("bond4-octahedral-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";
 
  ctxOcta1.clearRect(0, 0, cOcta1.width, cOcta1.height);
  ctxOcta2.clearRect(0, 0, cOcta2.width, cOcta2.height);
  ctxOcta3.clearRect(0, 0, cOcta3.width, cOcta3.height);
  ctxOcta4.clearRect(0, 0, cOcta4.width, cOcta4.height);
  ctxOcta5.clearRect(0, 0, cOcta5.width, cOcta5.height);
  ctxOcta6.clearRect(0, 0, cOcta6.width, cOcta6.height);
  ctxOcta7.clearRect(0, 0, cOcta7.width, cOcta7.height);
  ctxOcta.clearRect(0, 0, cOcta.width, cOcta.height);
  
  countOcta=alphaOcta=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
  drawCircleOcta();
}

/*
called when submit button is clicked
*/

function submitAnswerOctahedralTest() { 
  res["molecule"]=mol;
  res["ePairs"]=countOcta;
  var boxes = document.querySelectorAll(".octahedral-box");
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
  
  if (isEquivalentOctahedral(n, res) && selectedCorr==selected) {
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

var cOcta1 = document.getElementById("CanvasOcta1");
var cOcta2 = document.getElementById("CanvasOcta2");
var cOcta3 = document.getElementById("CanvasOcta3");
var cOcta4 = document.getElementById("CanvasOcta4");
var cOcta5 = document.getElementById("CanvasOcta5");
var cOcta6 = document.getElementById("CanvasOcta6");
var cOcta7 = document.getElementById("CanvasOcta7");
var cOcta = document.getElementById("CanvasOcta");

var ctxOcta1 = cOcta1.getContext("2d");
var ctxOcta2 = cOcta2.getContext("2d");
var ctxOcta3 = cOcta3.getContext("2d");
var ctxOcta4 = cOcta4.getContext("2d");
var ctxOcta5 = cOcta5.getContext("2d");
var ctxOcta6 = cOcta6.getContext("2d");
var ctxOcta7 = cOcta7.getContext("2d");
var ctxOcta = cOcta.getContext("2d");
ctxOcta1.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta2.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta3.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta4.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta5.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta6.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta7.strokeStyle = 'rgba(0,0,0,0.7)';
ctxOcta.strokeStyle = 'rgba(0,0,0,0)';

function drawCircleOcta(){

    ctxOcta1.beginPath();
    ctxOcta1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta1.stroke();

    ctxOcta2.beginPath();
    ctxOcta2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta2.stroke();

    ctxOcta3.beginPath();
    ctxOcta3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta3.stroke();

    ctxOcta4.beginPath();
    ctxOcta4.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta4.stroke();

    ctxOcta5.beginPath();
    ctxOcta5.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta5.stroke();

    ctxOcta6.beginPath();
    ctxOcta6.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta6.stroke();

    ctxOcta7.beginPath();
    ctxOcta7.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxOcta7.stroke();

    ctxOcta.beginPath();
    ctxOcta.arc(center_x1, center_y1, radius1, 0, 2 * Math.PI);
    ctxOcta.stroke();
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
drawCircleOcta();

function addPoints(alpha, canvas) {
  drawPoint(canvas,alpha+7,1,"");
  drawPoint(canvas,alpha-7,1,"");
}


/*
check is structures match
*/

function isEquivalentOctahedral(a, b) {
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

function changeImageOct(element) {
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
