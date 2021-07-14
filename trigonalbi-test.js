// Global variables 
var count17=0; // counts for lone pair additions
var atom;
var angles17 = [90,135,225,270,0]; // angles for circles (to add lone pair) 

// JSON variable for submitted molecule
var PF5_ans = { a1: "", a2: "", a3: "", a4: "", a5: "", a6: "", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0,a5_e: 0,a6_e: 0};

// JSON variable for correct molecule
var PF5_cor = { a1: "F", a2: "F", a3: "F", a4: "F", a5: "P", a6: "F", a1_e: 3, a2_e: 3, a3_e: 3, a4_e: 3, a5_e: 0, a6_e: 3};

// clear content in molecule

function clearBoxesTrigonalbiTest() {
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

  ctx17.clearRect(0, 0, c17.width, c17.height);
  PF5_ans.a3_e=PF5_ans.a2_e=PF5_ans.a1_e = 0;
  count17=alpha17=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerTrigonalbi() { 
  var a1 = document.getElementById("div1-trigonalbi").innerHTML;
  var a2 = document.getElementById("div2-trigonalbi").innerHTML;
  var a3 = document.getElementById("div3-trigonalbi").innerHTML;
  var a4 = document.getElementById("div4-trigonalbi").innerHTML;
  var a5 = document.getElementById("div5-trigonalbi").innerHTML;
  var a6 = document.getElementById("div6-trigonalbi").innerHTML;
  PF5_ans.a1 = a1;
  PF5_ans.a2 = a2;
  PF5_ans.a3 = a3;
  PF5_ans.a4 = a4;
  PF5_ans.a5 = a5;
  PF5_ans.a6 = a6;
  console.log(PF5_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentTrigonalbi(PF5_ans, PF5_cor)) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-trigonalbi").innerHTML;
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

var c17 = document.getElementById("Canvas17");

var ctx17 = c17.getContext("2d");
ctx17.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    ctx17.beginPath();
    ctx17.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx17.stroke(); 
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
