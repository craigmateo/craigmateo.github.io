
  
var canvas = new fabric.Canvas('a');
canvas.perPixelTargetFind = true;
canvas.targetFindTolerance = 4;
var json;
var line, isDown,mode;


// free draw

function startDraw() {
  mode="pencil";
  canvas.isDrawingMode = true;
  canvas.freeDrawingBrush.width = 6;
  console.log(canvas.freeDrawingBrush);
  fabric.PencilBrush.prototype.globalCompositeOperation = "source-over";
  // canvas.freeDrawingBrush.globalCompositeOperation = "source-over";
  canvas.renderAll();
}

// clear all

function clearCanvas() {
    canvas.clear();
}

// select

function select() {
  mode="select";
  canvas.isDrawingMode = false;   
  canvas.selection=true;
  canvas.renderAll();
}

// save as json

function saveCanvas() {
    json = canvas.toJSON();
    console.log(json);
  }

// image upload 

  document.getElementById('filereader').onchange = function handleImage(e) {
    var reader = new FileReader();
      reader.onload = function (event){
        var imgObj = new Image();
        imgObj.src = event.target.result;
        imgObj.onload = function () {
          var image = new fabric.Image(imgObj);
          image.set({
                angle: 0,
                padding: 10,
                cornersize:10,
                height:110,
                width:110,
          });
          canvas.centerObject(image);
          canvas.add(image);
          canvas.renderAll();
        }
      }
      reader.readAsDataURL(e.target.files[0]);
    }


// hexagon
function addHex() {
    canvas.isDrawingMode = false;
    var hexa = [ 	{x:850,y:75},
        {x:958,y:137.5},
        {x:958,y:262.5},
        {x:850,y:325},
        {x:742,y:262.5},
        {x:742,y:137.5},
        ];

    this.canvas.add(new fabric.Polygon(hexa,{
        left: this.canvas.width / 2,
        top: this.canvas.height / 2,
        fill: '#78909c',
        width: 100,
        height: 100,
        originX: 'center',
        originY: 'center',
        fill: 'white',
        stroke: 'black',
        strokeWidth: 5
    }));

}

// line

/* function addLine() {
    canvas.isDrawingMode = false;
    var line = [ 	{x:850,y:75},
        {x:958,y:137.5},
        ];

    this.canvas.add(new fabric.Polygon(line,{
        left: this.canvas.width / 2,
        top: this.canvas.height / 2,
        fill: '#78909c',
        width: 100,
        height: 100,
        originX: 'center',
        originY: 'center',
        fill: 'white',
        stroke: 'black',
        strokeWidth: 5
    }));
} */

// line draw 

function addLine() { 
  canvas.isDrawingMode = false;  
  mode="draw";
}




canvas.on('mouse:down', function(o){
  isDown = true;
  var pointer = canvas.getPointer(o.e);
  var points = [ pointer.x, pointer.y, pointer.x, pointer.y ];
   
  if(mode=="draw"){
    line = new fabric.Line(points, {
    strokeWidth: 5,
    fill: 'black',
    stroke: 'black',
    originX: 'center',
    originY: 'center',

  });
  canvas.add(line);}
});
 
canvas.on('mouse:move', function(o){
  if (!isDown) return;
  var pointer = canvas.getPointer(o.e);
  
  if(mode=="draw"){
  line.set({ x2: pointer.x, y2: pointer.y });
  canvas.renderAll(); }
});

canvas.on('mouse:up', function(o){
  isDown = false;
  if(line) {
  line.setCoords();
  }
});


$('button').on('click', function(){
  $('button').removeClass('selected');
  $(this).addClass('selected');
});


