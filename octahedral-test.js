// Global variables 
var count23=0; // counts for lone pair additions
var atom;
var angles23 = [90,135,225,270,-45,45]; // angles for circles (to add lone pair) 

// JSON variable for submitted molecule
var SF6_ans = { a1: "", a2: "", a3: "", a4: "", a5: "", a6: "", a7: "",a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0,a5_e: 0,a6_e: 0,a7_e: 0};

// JSON variable for correct molecule
var SF6_cor = { a1: "F", a2: "F", a3: "F", a4: "F", a5: "S", a6: "F", a7: "F",a1_e: 0, a2_e: 0, a3_e: 0, a4_e: 0, a5_e: 0, a6_e: 0,a7_e: 0};

// clear content in molecule

function clearBoxesOctahedralTest() {
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

  ctx23.clearRect(0, 0, c23.width, c23.height);

  SF6_ans.a3_e=SF6_ans.a2_e=SF6_ans.a1_e = 0;
  count23=alpha23=0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerOctahedralTest() { 
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
