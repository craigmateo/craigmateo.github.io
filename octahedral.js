// Global variables 
var count19=0; // counts for lone pair additions
var count20=0; 
var count21=0; 
var count22=0;
var count23=0; 
var count24=0;
var count25=0; 
var atom;
var angles19 = [90,270,0,180]; // angles for circles (to add lone pair) 
var angles20 = [90,270,180,0];
var angles21 = [90,180,0,270];
var angles22 = [0,180,270,90];
var angles23 = [0,180,270,90];
var angles24 = [0,180,90,270];
var angles25 = [0,180,90,270];

// JSON variable for submitted molecule
var SF6_ans = { a1: "", a2: "", a3: "", a4: "", a5: "", a6: "", a7: "",a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0,a5_e: 0,a6_e: 0,a7_e: 0};

// JSON variable for correct molecule
var SF6_cor = { a1: "F", a2: "F", a3: "F", a4: "F", a5: "S", a6: "F", a7: "F",a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0, a5_e: 0, a6_e: 0,a7_e: 0};

// clear content in molecule

function clearBoxesOctahedral() {
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
  ctx19.clearRect(0, 0, c19.width, c19.height);
  ctx20.clearRect(0, 0, c20.width, c20.height);
  ctx21.clearRect(0, 0, c21.width, c21.height);
  ctx22.clearRect(0, 0, c22.width, c22.height);
  ctx23.clearRect(0, 0, c23.width, c23.height);
  ctx24.clearRect(0, 0, c24.width, c24.height);
  ctx25.clearRect(0, 0, c25.width, c25.height);
  SF6_ans.a3_e=SF6_ans.a2_e=SF6_ans.a1_e = 0;
  count19=count20=count21=count22=count23=count24=count25=alpha19=alpha20=alpha21=alpha22=alpha23=alpha24=alpha25=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerOctahedral() { 
  var a1 = document.getElementById("div1-octahedral").innerHTML;
  var a2 = document.getElementById("div2-octahedral").innerHTML;
  var a3 = document.getElementById("div3-octahedral").innerHTML;
  var a4 = document.getElementById("div4-octahedral").innerHTML;
  var a5 = document.getElementById("div5-octahedral").innerHTML;
  var a6 = document.getElementById("div6-octahedral").innerHTML;
  var a7 = document.getElementById("div7-octahedral").innerHTML;
  SF6_ans.a1 = a1;
  SF6_ans.a2 = a2;
  SF6_ans.a3 = a3;
  SF6_ans.a4 = a4;
  SF6_ans.a5 = a5;
  SF6_ans.a6 = a6;
  SF6_ans.a7 = a7;
  console.log(SF6_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentOctahedral(SF6_ans, SF6_cor)) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-octahedral").innerHTML;
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

var c19 = document.getElementById("Canvas19");
var c20 = document.getElementById("Canvas20");
var c21 = document.getElementById("Canvas21");
var c22 = document.getElementById("Canvas22");
var c23 = document.getElementById("Canvas23");
var c24 = document.getElementById("Canvas24");
var c25 = document.getElementById("Canvas25");

var ctx19 = c19.getContext("2d");
ctx19.strokeStyle = 'rgba(0,0,0,0)';

var ctx20 = c20.getContext("2d");
ctx20.strokeStyle = 'rgba(0,0,0,0)';

var ctx21 = c21.getContext("2d");
ctx21.strokeStyle = 'rgba(0,0,0,0)';

var ctx22 = c22.getContext("2d");
ctx22.strokeStyle = 'rgba(0,0,0,0)';

var ctx23 = c23.getContext("2d");
ctx23.strokeStyle = 'rgba(0,0,0,0)';

var ctx24 = c24.getContext("2d");
ctx24.strokeStyle = 'rgba(0,0,0,0)';

var ctx25 = c25.getContext("2d");
ctx25.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    ctx19.beginPath();
    ctx19.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx19.stroke(); 
  
    ctx20.beginPath();
    ctx20.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx20.stroke(); 
  
    ctx21.beginPath();
    ctx21.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx21.stroke(); 

    ctx22.beginPath();
    ctx22.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx22.stroke();
    
    ctx23.beginPath();
    ctx23.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx23.stroke();
    
    ctx24.beginPath();
    ctx24.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx24.stroke(); 

    ctx25.beginPath();
    ctx25.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx25.stroke(); 
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
