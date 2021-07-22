// Global variables 
var countLinear=0; 
var atom;
var anglesLinear = [180,0];

// clear content in molecule

function clearBoxesLinear() {
  x = document.querySelectorAll(".dropBox");
  for (i = 0; i < x.length; i++) {
    x[i].innerHTML = ""; // clear boxes
    x[i].style.backgroundColor = ""; // clear box highlights
    console.clear();
  }
  icons = document.querySelectorAll(".atom");
  for (var i = 0; i < icons.length; i++) {
    icons[i].style.backgroundColor = ""; // clear previous atom highlight
  }
  
  eboxes = document.querySelectorAll(".e-box");
  for (var i = 0; i < eboxes.length; i++) {
    eboxes[i].innerHTML = ""; // clear previous atom highlight
  }

  var bonds = document.querySelectorAll(".bond");
  for (var i = 0; i < bonds.length; i++) {
    bonds[i].style.visibility = "visible"; // clear previous bond hidden
  }

  document.getElementById("bond-linear-1").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-linear-1.png";
  document.getElementById("bond-linear-2").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-linear-1.png";

  ctxLinear1.clearRect(0, 0, cLinear1.width, cLinear1.height);
  ctxLinear2.clearRect(0, 0, cLinear2.width, cLinear2.height);
  ctxLinear3.clearRect(0, 0, cLinear3.width, cLinear3.height);
  ctxLinear.clearRect(0, 0, cLinear.width, cLinear.height);

  countLinear=anglesLinear== 0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
  drawCircleLinear();
}

/*
called when submit button is clicked
*/

function submitAnswerLinear() { 
  res["molecule"]=mol;
  res["ePairs"]=countLinear;
  var boxes = document.querySelectorAll(".linear-box");
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
  console.log(n);
  console.log(res);
  
  if (isEquivalentLinear(n, res) && selectedCorr==selected) {
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

var cLinear1 = document.getElementById("CanvasLinear1");
var cLinear2 = document.getElementById("CanvasLinear2");
var cLinear3 = document.getElementById("CanvasLinear3");
var cLinear = document.getElementById("CanvasLinear");

var ctxLinear1 = cLinear1.getContext("2d");
ctxLinear1.strokeStyle = 'rgba(0,0,0,0.7)';
var ctxLinear2 = cLinear2.getContext("2d");
ctxLinear2.strokeStyle = 'rgba(0,0,0,0.7)';
var ctxLinear3 = cLinear3.getContext("2d");
ctxLinear3.strokeStyle = 'rgba(0,0,0,0.7)';
var ctxLinear = cLinear.getContext("2d");
ctxLinear.strokeStyle = 'rgba(0,0,0,0)';

function drawCircleLinear(){
    ctxLinear1.beginPath();
    ctxLinear1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxLinear1.stroke(); 
  
    ctxLinear2.beginPath();
    ctxLinear2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxLinear2.stroke(); 
  
    ctxLinear3.beginPath();
    ctxLinear3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctxLinear3.stroke(); 

    ctxLinear.beginPath();
    ctxLinear.arc(center_x1, center_y1, radius1, 0, 2 * Math.PI);
    ctxLinear.stroke(); 
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

drawCircleLinear();

//Execution


function addPoints(alpha, canvas) {
  drawPoint(canvas,alpha+7,1,"");
  drawPoint(canvas,alpha-7,1,"");
}


/*
check is structures match
*/

function isEquivalentLinear(a, b) {
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

function changeImage(element) {
  var s = element.src;
  var srcs = ["https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-linear-1.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/double-1.png", "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/triple-1.png"];
  var i = srcs.indexOf(s);
  if (i<2) {
  element.src=srcs[i+1];
  } 
  else {
    element.src=srcs[0]; 
  }
}