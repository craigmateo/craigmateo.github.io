// Global variables 
var count8=0; // counts for lone pair additions
var count9=0; 
var count10=0; 
var count11=0;
var count12=0; 
var atom;
var angles8 = [90,270,0,180]; // angles for circles (to add lone pair) 
var angles9 = [90,270,180,0];
var angles10 = [90,270,0,180];
var angles11 = [0,180,270,90];
var angles12 = [90, 270,180,0];

// JSON variable for submitted molecule
var CH4_ans = { a1: "", a2: "", a3: "", a4: "", a5: "", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0,a5_e: 0};

// JSON variable for correct molecule
var CH4_cor = { a1: "H", a2: "H", a3: "H", a4: "H", a5: "C", a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0, a5_e: 0};

// clear content in molecule

function clearBoxesTetra() {
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
  ctx8.clearRect(0, 0, c8.width, c8.height);
  ctx9.clearRect(0, 0, c9.width, c9.height);
  ctx10.clearRect(0, 0, c10.width, c10.height);
  ctx11.clearRect(0, 0, c11.width, c11.height);
  ctx12.clearRect(0, 0, c12.width, c12.height);
  CH4_ans.a3_e=CH4_ans.a2_e=CH4_ans.a1_e = 0;
  count8=count9=count10=count11=count12=alpha8=alpha9=alpha10=alpha11=alpha12=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerTetra() { 
  var a1 = document.getElementById("div1-tetra").innerHTML;
  var a2 = document.getElementById("div2-tetra").innerHTML;
  var a3 = document.getElementById("div3-tetra").innerHTML;
  var a4 = document.getElementById("div4-tetra").innerHTML;
  var a5 = document.getElementById("div5-tetra").innerHTML;
  CH4_ans.a1 = a1;
  CH4_ans.a2 = a2;
  CH4_ans.a3 = a3;
  CH4_ans.a4 = a4;
  CH4_ans.a5 = a5;
  console.log(CH4_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentTetra(CH4_ans, CH4_cor)) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-tetra").innerHTML;
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

var c8 = document.getElementById("Canvas8");
var c9 = document.getElementById("Canvas9");
var c10 = document.getElementById("Canvas10");
var c11 = document.getElementById("Canvas11");
var c12 = document.getElementById("Canvas12");

var ctx8 = c8.getContext("2d");
ctx8.strokeStyle = 'rgba(0,0,0,0)';

var ctx9 = c9.getContext("2d");
ctx9.strokeStyle = 'rgba(0,0,0,0)';

var ctx10 = c10.getContext("2d");
ctx10.strokeStyle = 'rgba(0,0,0,0)';

var ctx11 = c11.getContext("2d");
ctx11.strokeStyle = 'rgba(0,0,0,0)';

var ctx12 = c12.getContext("2d");
ctx12.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    ctx8.beginPath();
    ctx8.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx8.stroke(); 
  
    ctx9.beginPath();
    ctx9.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx9.stroke(); 
  
    ctx10.beginPath();
    ctx10.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx10.stroke(); 

    ctx11.beginPath();
    ctx11.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx11.stroke();
    
    ctx12.beginPath();
    ctx12.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx12.stroke(); 
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
