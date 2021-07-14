var data = '[{ "molecule":"SF6", "S":1, "F":6, "ePairs":0 }, { "molecule":"CH4", "C":1, "H":4, "ePairs":0 }, { "molecule":"BH3", "B":1, "H":3, "ePairs":0 }, { "molecule":"PF5", "P":1, "F":5, "ePairs":0 }]';

var selected;
var moleculeVars = ["CO2","BH3","CH4","PF5","SF6"];
var molecules = ["CO<sub>2</sub>","BH<sub>3</sub>","CH<sub>4</sub>","PF<sub>5</sub>","SF<sub>6</sub>"];
var structures = ["linear","tri_planar-test","tetrahedral-test","trigonalbi-test","octahedral-test"];
var rand = Math.floor(Math.random() * molecules.length);
var mol = moleculeVars[rand];
var selectedCorr = structures[rand];
document.getElementById("variationMol").innerHTML = molecules[rand];
var m = JSON.parse(data);
var n;

// get corresponding JSON data

for (var i = 0; i < m.length; i++) {
  if (mol==m[i].molecule) {
    n=m[i];
  }
}

// response object

var res = {};

// dropdown on change function; molecule shell structure; linear is visible by default (will change to display: none later) 
function place() { 
    clearAll(selected);
    var all = document.querySelectorAll(".step2");
    for (var i = 0; i < all.length; i++) {
        all[i].style.display = "none"; // clear previous structure
    }
    var e = document.getElementById("geometry");
    var f = e.options[e.selectedIndex].value;
    var id = "step2-" + f;
    selected = f;
    document.getElementById(id).style.display = "block";   
}

place();

function clearAll(s) {

  var res = {};

  if (s=="linear") {
    clearBoxesLinear();
  }

  if (s=="tri_planar-test") {
    clearBoxesPlanarTest()
  }

  if (s=="tetrahedral-test") {
    clearBoxesTetraTest();
  }

  if (s=="trigonalbi-test") {
    clearBoxesTrigonalbiTest(); 
  }

  if (s=="octahedral-test") {
    clearBoxesOctahedralTest();
  }

}


/* 
PARENT FUNCTION

Executes when an "atom" icon is selected from the menu (including lone pair icon) 

*/

jQuery(".atom").click(function(){
  atom = this.id;

  icons = document.querySelectorAll(".atom");
  for (var i = 0; i < icons.length; i++) {
    icons[i].style.backgroundColor = ""; // clear previous atom highlight
  }
  
  document.getElementById(atom).style.backgroundColor = "#FBFB92"; // highlight new selection
  
  // highlight boxes where atom can be placed
  x = document.querySelectorAll(".dropBox");
  for (i = 0; i < x.length; i++) {
    x[i].style.backgroundColor = "#FBFB92";
    x[i].style.cursor = "pointer";
  }

  // CHILD FUNCTION: 
  // if atom is not a lone pair, place atom in target box
  jQuery(".dropBox").click(function(e){
  
    e.stopImmediatePropagation(); 
   
     var target_box = this.id;
     var div_id = target_box.substring(0, 4); 
      if (atom !== "pair") {
        document.getElementById(target_box).innerHTML = atom;
      }
    
    // if atom is a lone pair, place lone pairs on atom

    if (atom === "pair") {

    if (selected=="linear") {

        if (div_id=="div3") {
          addPoints(angles3[count3], ctx3);
          CO2_ans.a3_e += 1;
          count3 += 1;
        }
        
        if (div_id=="div2") {
          addPoints(angles2[count2], ctx2);
          CO2_ans.a2_e += 1;
          count2 += 1;

        }
        
        if (div_id=="div1") {
          addPoints(angles1[count1], ctx1);
          CO2_ans.a1_e += 1;
          count1 += 1;
        }
    }

      else if (selected=="tetrahedral-test") {
        document.getElementById(target_box).innerHTML = "&#183;&#183;";
        var div_id_new = div_id+"-tetra-test";
        var bondid = div_id_new.replace("div", "bond");
        document.getElementById(bondid).style.visibility ="hidden";
        document.getElementById(div_id+"-tetra-test").style.visibility ="hidden";

        var numStr = div_id.replace("div","");
        var num = parseInt(numStr);

        addPoints(angles26[num-1], ctx26);
        count26 += 1;
      }

      else if (selected=="tri_planar-test") {
        document.getElementById(target_box).innerHTML = "&#183;&#183;";
        var div_id_new = div_id+"-tri_planar-test";
        var bondid = div_id_new.replace("div", "bond");
        document.getElementById(bondid).style.visibility ="hidden";
        document.getElementById(div_id+"-tri_planar-test").style.visibility ="hidden";

        var numStr = div_id.replace("div","");
        var num = parseInt(numStr);

        addPoints(angles7[num-1], ctx7);
        count7 += 1;
      }

      else if (selected=="trigonalbi-test") {
        document.getElementById(target_box).innerHTML = "&#183;&#183;";
        var div_id_new = div_id+"-trigonalbi-test";
        var bondid = div_id_new.replace("div", "bond");
        document.getElementById(bondid).style.visibility ="hidden";
        document.getElementById(div_id+"-trigonalbi-test").style.visibility ="hidden";

        var numStr = div_id.replace("div","");
        var num = parseInt(numStr);

        addPoints(angles17[num-1], ctx17);
        count17 += 1;
      }

      else if (selected=="octahedral-test") {
        document.getElementById(target_box).innerHTML = "&#183;&#183;";
        var div_id_new = div_id+"-octahedral-test";
        var bondid = div_id_new.replace("div", "bond");
        document.getElementById(bondid).style.visibility ="hidden";
        document.getElementById(div_id+"-octahedral-test").style.visibility ="hidden";

        var numStr = div_id.replace("div","");
        var num = parseInt(numStr);

        addPoints(angles23[num-1], ctx23);
        count23 += 1;
      }

    }  
    
  });
  
 // END OF PARENT 
});
  
