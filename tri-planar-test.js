// Global variables 
var count7=0; // counts for lone pair additions
var atom;
var angles7 = [90,225,315]; // angles for circles (to add lone pair) 

// JSON variable for submitted molecule
var BH3_ans = { a1: "", a2: "", a3: "", a4: "", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0};

// JSON variable for correct molecule
var BH3_cor = { a1: "H", a2: "H", a3: "H", a4: "Br", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0};

// clear content in molecule

function clearBoxesPlanarTest() {
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

  ctx7.clearRect(0, 0, c7.width, c7.height);
  BH3_ans.a3_e=BH3_ans.a2_e=BH3_ans.a1_e = 0;
  count7=alpha7=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerPlanar() { 
  var a1 = document.getElementById("div1-trigonal").innerHTML;
  var a2 = document.getElementById("div2-trigonal").innerHTML;
  var a3 = document.getElementById("div3-trigonal").innerHTML;
  var a4 = document.getElementById("div5-trigonal").innerHTML;
  BH3_ans.a1 = a1;
  BH3_ans.a2 = a2;
  BH3_ans.a3 = a3;
  BH3_ans.a4 = a4;
  console.log(BH3_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentPlanar(BH3_ans, BH3_cor)) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-trigonal").innerHTML;
  }
  
  else {
    console.log("Incorrect.");
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

var c7 = document.getElementById("Canvas7");

var ctx7 = c7.getContext("2d");
ctx7.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    
    ctx7.beginPath();
    ctx7.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx7.stroke(); 
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
