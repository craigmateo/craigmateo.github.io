var data = '[{ "molecule":"CO2", "structure":"linear", "C":1, "O":2, "ePairs":0, "center-atom":"C"},{ "molecule":"SF6", "structure":"octahedral", "S":1, "F":6, "ePairs":0, "center-atom":"S"}, { "molecule":"CH4", "structure":"tetrahedral", "C":1, "H":4, "ePairs":0, "center-atom":"C"}, { "molecule":"BH3", "structure":"tri-planar", "B":1, "H":3, "ePairs":0, "center-atom":"B"}, { "molecule":"PF5", "structure":"tri-bi", "P":1, "F":5, "ePairs":0, "center-atom":"P", single-bonds="5", double-bonds="0", triple-bonds="0"}]';
var res = {};
var selected;
var moleculeVars = ["CO2","BH3","CH4","PF5","SF6"];
var molecules = ["CO<sub>2</sub>","BH<sub>3</sub>","CH<sub>4</sub>","PF<sub>5</sub>","SF<sub>6</sub>"];
var rand = Math.floor(Math.random() * molecules.length);
var mol = moleculeVars[rand];
document.getElementById("variationMol").innerHTML = molecules[rand];
var m = JSON.parse(data);
var n;

// get corresponding JSON data

for (var i = 0; i < m.length; i++) {
  if (mol==m[i].molecule) {
    n=m[i];
  }
}


function refreshPage(){
  window.location.reload();
} 


var atom = ' ';
var target_box;

var currentMolecule = 'tri-bi';

displayMolecule(currentMolecule);

/* Runs everytime the atom selection buttons are pressed */

jQuery("#element-table button").click(function(){
  atom = this.id;

  var icons = document.querySelectorAll("#element-table button");
  for (var i = 0; i < icons.length; i++) {
    icons[i].style.backgroundColor = "";
  }
  document.getElementById(atom).style.backgroundColor = "#FBFB92";

  var x = document.querySelectorAll("svg > circle, #legs circle");

  for (i = 0; i < x.length; i++) {
    x[i].style.fill = "#FBFB92";
    x[i].style.cursor = "pointer";
  }

});

/* Runs everytime the molecule placeholders are pressed (aka the big circles) */

  jQuery(".step2 p").click(function(e){
     target_box = this.id;
     target_box = target_box.match(/(\d+)/);
     target_box = parseFloat(target_box[0]);
      if (atom != "pair") {

        document.querySelectorAll("#" + currentMolecule + " p")[target_box - 1].innerHTML = atom;
      }
      else if(atom == "pair" && target_box != 1) {

        document.querySelectorAll("#" + currentMolecule + ' #legs > g')[target_box - 2].style.display = 'none';
        document.querySelectorAll("#" + currentMolecule + " p")[target_box - 1].style.display = 'none';
        document.querySelectorAll("#" + currentMolecule + ' #dots > g')[target_box - 2].style.display = 'inline-flex';
    }
  });

/* Runs everytime the lone pairs are pressed (aka the dots) */

  jQuery("#dots > g").click(function(e){

    var dotId = this.id;
    dotId = dotId.match(/(\d+)/);
    dotId = parseFloat(dotId[0]);

    var legs = document.querySelectorAll("#" + currentMolecule + " #legs > g");


    legs[(dotId - 1)].style.display = 'block';

    document.querySelectorAll("#" + currentMolecule + " p")[dotId].style.display = 'inline-flex';
    if(atom != "pair"){document.querySelectorAll("#" + currentMolecule + " p")[dotId].innerHTML = atom;}
    document.querySelectorAll("#" + currentMolecule + ' #dots > g')[dotId - 1].style.display = 'none';

  });


  /* Runs everytime a molecules bonds are pressed (aka the 1 - 3 lines) */

  jQuery("#legs > g > polygon").click(function(e){

    var displayCount = 0;
    var groupId = this.id;
    groupNum = groupId.match(/(\d+)/);
    groupNum = parseFloat(groupNum[0]);

    var lines = document.querySelectorAll("#" + currentMolecule + " #legs #leg" + groupNum + ' line');
    var polygons = document.querySelectorAll("#" + currentMolecule + " #legs #leg" + groupNum + ' > g > polygon');
    var amount = polygons.length;

      for(var i = 0; i < lines.length; i++){
        if(lines[i].style.display == 'block'){
          displayCount++;
        }
      }
      if(amount == 0){
        switch(displayCount){
          case 1:
            lines[0].style.display = 'block';
            lines[1].style.display = 'none';
            lines[2].style.display = 'block';
            break;
          case 2:
            lines[1].style.display = 'block';
            break;
          case 3:
            lines[0].style.display = 'none';
            lines[2].style.display = 'none';
            break;
          default:
          lines[0].style.display = 'none';
          lines[1].style.display = 'block';
          lines[2].style.display = 'none';
        }
    }else{
        switch(displayCount) {
          case 1:
            lines[0].style.display = 'block';
            lines[1].style.display = 'none';
            lines[2].style.display = 'block';
            break;
          case 2:
            lines[1].style.display = 'block';
            break;
          case 3:
            for(var i = 0; i < amount; i++){
              polygons[i].style.display = 'block';
            }
            lines[0].style.display = 'none';
            lines[1].style.display = 'none';
            lines[2].style.display = 'none';
            break;
          default:
          for(var i = 0; i < amount; i++){
            polygons[i].style.display = 'none';
          }
          lines[0].style.display = 'block';
          lines[2].style.display = 'block';
        }
      }

  });

  function displayMolecule(value){

    var molecules = document.querySelectorAll(".shell div");
    for(var i = 0; i < molecules.length; i++){
      molecules[i].style.display = 'none';
    }
    currentMolecule = value;
    document.getElementById(value).style.display = 'block';

  }


  function submit() {
    atomList=[];
    res["structure"]=currentMolecule;
    // get atoms and add results to res object
    var atoms = document.querySelectorAll("."+currentMolecule+"-atom");
    var centreAtom = atoms[0].innerHTML;
    res["center-atom"] = centreAtom;
    for(var i = 0; i < atoms.length; i++){
      var a = atoms[i].innerHTML;
      if (a.length >0) {
        if (res.hasOwnProperty(a)) {
          res[a]+=1;
        }
        else {
          res[a]=1;
        }
      }
    }

    res["ePairs"]=0;

    var pairs = document.querySelectorAll("."+currentMolecule + "-dot");
    for(var j = 0; j < pairs.length; j++){
      var s = pairs[j].getAttribute("style");
      if (s !== null) {
        res["ePairs"]+=1;
      }
         
    }

    res["single-bonds"]=0;
    res["double-bonds"]=0;
    res["triple-bonds"]=0;

    var legs = document.querySelectorAll("."+currentMolecule + "-leg");
    for(var k = 0; k < legs.length; k++){
      var ch = legs[k].children;
      var num = 0;
      for(var m = 0; m < ch.length; m++){
        var i = ch[m].id;
        if (i.includes("line") && i.includes("Zone")==false) {
          var s = ch[m].getAttribute("style");
          if (s !== null && s.includes("block")) {
            num+=1;
          }
        }
      }
      if (num==2) {
        res["double-bonds"]+=1;
      }
      if (num==3) {
        res["triple-bonds"]+=1;
      }
      else {
        res["single-bonds"]+=1;
      }
    }


    res["molecule"]=mol;

    console.log(n);
    console.log(res);
    if (isEquivalent(n,res)) {
      fb.innerHTML = "Correct!";
    }
    else {
      fb.innerHTML = "Incorrect";
    }
  
  }



  /*
check is structures match
*/

function isEquivalent(a, b) {
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
