// Global variables 
var countTri=0; // counts for lone pair additions
var atom;
var anglesTri = [90,225,315]; // angles for circles (to add lone pair) 

// clear content in molecule

function clearBoxesPlanarTest() {
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

  document.getElementById("bond1-tri_planar-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";
  document.getElementById("bond2-tri_planar-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-2.png";
  document.getElementById("bond3-tri_planar-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-5.png";

  ctxTri1.clearRect(0, 0, cTri1.width, cTri1.height);
  ctxTri2.clearRect(0, 0, cTri2.width, cTri2.height);
  ctxTri3.clearRect(0, 0, cTri3.width, cTri3.height);
  ctxTri.clearRect(0, 0, cTri.width, cTri.height);
  countTri=alphaTri=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
  drawCircleTri();
}

/*
called when submit button is clicked
*/

function submitAnswerPlanar() { 
  res["molecule"]=mol;
  res["ePairs"]=countTri;
  var boxes = document.querySelectorAll(".tri_planar-box");
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

var cTri1 = document.getElementById("CanvasTri1");
var cTri2 = document.getElementById("CanvasTri2");
var cTri3 = document.getElementById("CanvasTri3");
var cTri = document.getElementById("CanvasTri");

var ctxTri1 = cTri1.getContext("2d");
var ctxTri2 = cTri2.getContext("2d");
var ctxTri3 = cTri3.getContext("2d");
var ctxTri = cTri.getContext("2d");

ctxTri1.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTri2.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTri3.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTri.strokeStyle = 'rgba(0,0,0,0.4)';

function drawCircleTri(){

    ctxTri1.beginPath();
    ctxTri1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTri1.stroke();

    ctxTri2.beginPath();
    ctxTri2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTri2.stroke();

    ctxTri3.beginPath();
    ctxTri3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTri3.stroke();

    ctxTri.beginPath();
    ctxTri.arc(center_x1, center_y1, radius1, 0, 2 * Math.PI);
    ctxTri.stroke(); 
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
drawCircleTri();

function addPoints(alpha, canvas) {
  drawPoint(canvas,alpha+7,1,"");
  drawPoint(canvas,alpha-7,1,"");
}


/*
check is structures match
*/

function isEquivalentPlanar(a, b) {
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

function changeImageTriPl1(element) {
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

function changeImageTriPl2(element) {
  var s = element.src;
  var srcs = ["https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-2.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/double-3.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/triple-3.png"];
  var i = srcs.indexOf(s);
  if (i<2) {
  element.src=srcs[i+1];
  } 
  else {
    element.src=srcs[0]; 
  }
}

function changeImageTriPl3(element) {
  var s = element.src;
  var srcs = ["https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-5.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/double-4.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/triple-4.png"];
  var i = srcs.indexOf(s);
  if (i<2) {
  element.src=srcs[i+1];
  } 
  else {
    element.src=srcs[0]; 
  }
}
