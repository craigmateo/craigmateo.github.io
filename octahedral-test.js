// Global variables 
var count23=0; // counts for lone pair additions
var atom;
var angles23 = [90,135,225,270,-45,45]; // angles for circles (to add lone pair) 

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


  ctx23.clearRect(0, 0, c23.width, c23.height);

  count23=alpha23=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerOctahedralTest() { 
  res["molecule"]=mol;
  res["ePairs"]=count23;
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
var radius = 32;
var point_size = 2;
var center_x = 35;
var center_y = 34;
var font_size = "15px";

var c23 = document.getElementById("Canvas23");

var ctx23 = c23.getContext("2d");
ctx23.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    ctx23.beginPath();
    ctx23.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx23.stroke();
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
drawCircle();

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
