var selected;
var moleculeVars = ["CO2","BH3","CH4","PF5","SF6"];
var molecules = ["CO<sub>2</sub>","BH<sub>3</sub>","CH<sub>4</sub>","PF<sub>5</sub>","SF<sub>6</sub>"];
var randomMol = molecules[Math.floor(Math.random() * molecules.length)];
document.getElementById("variationMol").innerHTML = randomMol;


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
    console.log(selected);
    document.getElementById(id).style.display = "block";   
}

place();

function clearAll(s) {

  if (s=="linear") {
    clearBoxesLinear();

  }

  if (s=="tri_planar") {
    clearBoxesPlanar()
  }

  if (s=="tetrahedral-test") {
    clearBoxesTetra();
  }

  if (s=="tetrahedral") {
    clearBoxesTetra();
  }

  if (s=="trigonalbi") {
    clearBoxesTrigonalbi();
    
  }

  if (s=="octahedral") {
    clearBoxesOctahedral();
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
      console.log(div_id);
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

    else if (selected=="tri_planar") {
        if (div_id=="div3") {
          addPoints(angles4[count4], ctx4);
          BH3_ans.a1_e += 1;
          count4 += 1;
        }
        
        if (div_id=="div2") {
          addPoints(angles5[count5], ctx5);
          BH3_ans.a2_e += 1;
          count5 += 1;

        }
        
        if (div_id=="div1") {
          addPoints(angles6[count6], ctx6);
          BH3_ans.a3_e += 1;
          count6 += 1;
        }

        if (div_id=="div5") {
          addPoints(angles7[count7], ctx7);
          BH3_ans.a4_e += 1;
          count7 += 1;
        }
        
      }

      else if (selected=="tetrahedral") {
        if (div_id=="div3") {
          addPoints(angles8[count8], ctx8);
          CH4_ans.a1_e += 1;
          count8 += 1;
        }
        
        if (div_id=="div2") {
          addPoints(angles9[count9], ctx9);
          CH4_ans.a2_e += 1;
          count9 += 1;

        }
        
        if (div_id=="div1") {
          addPoints(angles10[count10], ctx10);
          CH4_ans.a3_e += 1;
          count10 += 1;
        }

        if (div_id=="div4") {
          addPoints(angles11[count11], ctx11);
          CH4_ans.a4_e += 1;
          count11 += 1;
        }

        if (div_id=="div5") {
          addPoints(angles12[count12], ctx12);
          CH4_ans.a5_e += 1;
          count12 += 1;
        }
        
      }

      else if (selected=="trigonalbi") {
        if (div_id=="div3") {
          addPoints(angles19[count19], ctx19);
          PF5_ans.a1_e += 1;
          count19 += 1;
        }
        
        if (div_id=="div2") {
          addPoints(angles14[count14], ctx14);
          PF5_ans.a2_e += 1;
          count14 += 1;

        }
        
        if (div_id=="div1") {
          addPoints(angles15[count15], ctx15);
          PF5_ans.a3_e += 1;
          count15 += 1;
        }

        if (div_id=="div4") {
          addPoints(angles16[count16], ctx16);
          PF5_ans.a4_e += 1;
          count16 += 1;
        }

        if (div_id=="div5") {
          addPoints(angles17[count17], ctx17);
          PF5_ans.a5_e += 1;
          count17 += 1;
        }

        if (div_id=="div6") {
          addPoints(angles18[count18], ctx18);
          PF5_ans.a6_e += 1;
          count18 += 1;
        }
        
      }


      else if (selected=="octahedral") {
        if (div_id=="div3") {
          addPoints(angles19[count19], ctx19);
          PF5_ans.a1_e += 1;
          count19 += 1;
        }
        
        if (div_id=="div2") {
          addPoints(angles20[count20], ctx20);
          PF5_ans.a2_e += 1;
          count20 += 1;

        }
        
        if (div_id=="div1") {
          addPoints(angles21[count21], ctx21);
          PF5_ans.a3_e += 1;
          count21 += 1;
        }

        if (div_id=="div4") {
          addPoints(angles22[count22], ctx22);
          PF5_ans.a4_e += 1;
          count22 += 1;
        }

        if (div_id=="div5") {
          addPoints(angles23[count23], ctx23);
          PF5_ans.a5_e += 1;
          count23 += 1;
        }

        if (div_id=="div6") {
          addPoints(angles24[count24], ctx24);
          PF5_ans.a6_e += 1;
          count24 += 1;
        }

        if (div_id=="div7") {
          addPoints(angles25[count25], ctx25);
          PF5_ans.a6_e += 1;
          count25 += 1;
        }
        
      }

      else if (selected=="tetrahedral-test") {
        document.getElementById(target_box).innerHTML = "&#183;&#183;";
        var div_id_new = div_id+"-tetra-test";
        var bondid = div_id_new.replace("div", "bond");
        console.log(bondid);
        document.getElementById(bondid).style.visibility ="hidden";
        document.getElementById(div_id+"-tetra-test").style.visibility ="hidden";

        var numStr = div_id.replace("div","");
        var num = parseInt(numStr);

        addPoints(angles26[num-1], ctx26);
        CH4_ans.a5_e += 1;
        count26 += 1;


      }
    }

  
    
  });
  
 // END OF PARENT 
});
  
