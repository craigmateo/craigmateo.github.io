// Global variables 
var count26=0; // counts for lone pair additions
var atom;
var angles26 = [90,220,300,-20]; // angles for circles (to add lone pair) 


// JSON variable for submitted molecule
var CH4_ans = { a1: "", a2: "", a3: "", a4: "", a5: "", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0,a5_e: 0};

// JSON variable for correct molecule
var CH4_cor = { a1: "H", a2: "H", a3: "H", a4: "H", a5: "C", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0, a5_e: 0};

// clear content in molecule

function clearBoxesTetraTest() {
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

  ctx26.clearRect(0, 0, c26.width, c26.height);
  CH4_ans.a3_e=CH4_ans.a2_e=CH4_ans.a1_e = 0;
  count26=alpha26=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerTetra() { 
  var a1 = document.getElementById("div1-tetra-test").innerHTML;
  var a2 = document.getElementById("div2-tetra-test").innerHTML;
  var a3 = document.getElementById("div3-tetra-test").innerHTML;
  var a4 = document.getElementById("div4-tetra-test").innerHTML;
  var a5 = document.getElementById("div5-tetra-test").innerHTML;
  CH4_ans.a1 = a1;
  CH4_ans.a2 = a2;
  CH4_ans.a3 = a3;
  CH4_ans.a4 = a4;
  CH4_ans.a5 = a5;
  console.log(CH4_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentTetra(CH4_ans, CH4_cor)) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-tetra-test").innerHTML;
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

var c26 = document.getElementById("Canvas26");
var ctx26 = c26.getContext("2d");
ctx26.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){   
    ctx26.beginPath();
    ctx26.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx26.stroke(); 
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
