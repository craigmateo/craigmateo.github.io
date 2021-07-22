// Global variables 
var countTetra=0; // counts for lone pair additions
var atom;
var anglesTetra = [90,220,300,-20]; // angles for circles (to add lone pair) 

// clear content in molecule

function clearBoxesTetraTest() {
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

  document.getElementById("bond1-tetra-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-1.png";
  document.getElementById("bond2-tetra-test").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-2.png";

  ctxTetra1.clearRect(0, 0, cTetra1.width, cTetra1.height);
  ctxTetra2.clearRect(0, 0, cTetra2.width, cTetra2.height);
  ctxTetra3.clearRect(0, 0, cTetra3.width, cTetra3.height);
  ctxTetra4.clearRect(0, 0, cTetra4.width, cTetra4.height);
  ctxTetra5.clearRect(0, 0, cTetra5.width, cTetra5.height);
  ctxTetra.clearRect(0, 0, cTetra.width, cTetra.height);
  countTetra=alphaTetra=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
  drawCircle();
}

/*
called when submit button is clicked
*/

function submitAnswerTetra() { 
  res["molecule"]=mol;
  res["ePairs"]=countTetra;
  var boxes = document.querySelectorAll(".tetra-box");
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

var cTetra1 = document.getElementById("CanvasTetra1");
var cTetra2 = document.getElementById("CanvasTetra2");
var cTetra3 = document.getElementById("CanvasTetra3");
var cTetra4 = document.getElementById("CanvasTetra4");
var cTetra5 = document.getElementById("CanvasTetra5");
var cTetra = document.getElementById("CanvasTetra");
var ctxTetra1 = cTetra1.getContext("2d");
var ctxTetra2 = cTetra2.getContext("2d");
var ctxTetra3 = cTetra3.getContext("2d");
var ctxTetra4 = cTetra4.getContext("2d");
var ctxTetra5 = cTetra5.getContext("2d");
var ctxTetra = cTetra.getContext("2d");
ctxTetra1.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTetra2.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTetra3.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTetra4.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTetra5.strokeStyle = 'rgba(0,0,0,0.7)';
ctxTetra.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
  
    ctxTetra1.beginPath();
    ctxTetra1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTetra1.stroke();

    ctxTetra2.beginPath();
    ctxTetra2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTetra2.stroke();
  
    ctxTetra3.beginPath();
    ctxTetra3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTetra3.stroke(); 

    ctxTetra4.beginPath();
    ctxTetra4.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTetra4.stroke(); 

    ctxTetra5.beginPath();
    ctxTetra5.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxTetra5.stroke();
    
    ctxTetra.beginPath();
    ctxTetra.arc(center_x1, center_y1, radius1, 0, 2 * Math.PI);
    ctxTetra.stroke();
}

function drawPoint(c,angle,distance,label){
    var x = center_x1 + radius1 * Math.cos(-angle*Math.PI/180) * distance;
    var y = center_y1 + radius1 * Math.sin(-angle*Math.PI/180) * distance;

    c.beginPath();
    c.arc(x, y, point_size, 0, 2 * Math.PI);
    c.fill();

    c.font = font_size;
    c.fillText(label,x + 10,y);
}

//Execution
drawCircle();

function addPoints(alpha, canvas) {
  drawPoint(canvas,alpha+7,1,"");
  drawPoint(canvas,alpha-7,1,"");
}


/*
check is structures match
*/

function isEquivalentTetra(a, b) {
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

function changeImageTetra1(element) {
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

function changeImageTetra2(element) {
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
