
var atom = ' ';
var target_box;

var currentMolecule = 'tri-planar';

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
     console.log(target_box);
     console.log("#" + currentMolecule + " p");
      if (atom != "pair") {
        console.log(target_box);
        document.querySelectorAll("#" + currentMolecule + " p")[target_box - 1].innerHTML = atom;
      }
      else if(atom == "pair" && target_box != 1) {

        console.log(document.querySelectorAll("#" + currentMolecule + ' #legs > g'));

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
    console.log(currentMolecule);
    document.getElementById(value).style.display = 'block';

  }
