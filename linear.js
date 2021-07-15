// Global variables 
var count1=0; // counts for lone pair additions
var count2=0; 
var count3=0; 
var atom;
var angles1 = [90,270]; // angles for circles (to add lone pair) 
var angles2 = [90,270,180];
var angles3 = [90,270,0];

// JSON variable for submitted molecule
var CO2_ans = { a1: "", a2: "", a3: "", a1_e: 0, a2_e: 0, a3_e: 0};

// JSON variable for correct molecule
var CO2_cor = { a1: "C", a2: "O", a3: "O", a1_e: 0, a2_e: 2, a3_e: 2};

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

  document.getElementById("bond-linear-1").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-linear-1.png";
  document.getElementById("bond-linear-2").src = "https://van-griner.mobius.cloud/web/Htmlc000/Public_Html/chemTool/bond-linear-1.png";

  ctx1.clearRect(0, 0, c1.width, c1.height);
  ctx2.clearRect(0, 0, c2.width, c2.height);
  ctx3.clearRect(0, 0, c3.width, c3.height);
  CO2_ans.a3_e=CO2_ans.a2_e=CO2_ans.a1_e = 0;
  count1=count2=count3=alpha1=alpha2=alpha3 = 0;
  atom="";
  document.getElementById("feedback").innerHTML = "&nbsp;";
}

/*
called when submit button is clicked
*/

function submitAnswerLinear() { 
  var a1 = document.getElementById("div1-linear").innerHTML;
  var a2 = document.getElementById("div2-linear").innerHTML;
  var a3 = document.getElementById("div3-linear").innerHTML;
  var img1 = document.getElementById("bond-linear-1").src;
  var img2 = document.getElementById("bond-linear-2").src;
  CO2_ans.a1 = a1;
  CO2_ans.a2 = a2;
  CO2_ans.a3 = a3;
  console.log(CO2_ans);
  var fb = document.getElementById("feedback");
  
  if (isEquivalentLinear(CO2_ans, CO2_cor) && img1.includes("double") && img2.includes("double")) {
    fb.innerHTML = "Correct!";
    document.getElementById("div1-linear").innerHTML;
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

var c1 = document.getElementById("Canvas1");
var c2 = document.getElementById("Canvas2");
var c3 = document.getElementById("Canvas3");

var ctx1 = c1.getContext("2d");
ctx1.strokeStyle = 'rgba(0,0,0,0)';

var ctx2 = c2.getContext("2d");
ctx2.strokeStyle = 'rgba(0,0,0,0)';

var ctx3 = c3.getContext("2d");
ctx3.strokeStyle = 'rgba(0,0,0,0)';

function drawCircle(){
    ctx1.beginPath();
    ctx1.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx1.stroke(); 
  
    ctx2.beginPath();
    ctx2.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx2.stroke(); 
  
    ctx3.beginPath();
    ctx3.arc(center_x, center_y, radius, 0, 2 * Math.PI);
    ctx3.stroke(); 
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