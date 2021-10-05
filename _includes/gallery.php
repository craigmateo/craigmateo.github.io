<!DOCTYPE html>
<div>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>



/* Center website */
.main {
  max-width: 1000px;
  margin: auto;
}


.gallery.row {
  margin: 10px -16px;
}

/* Add padding BETWEEN each column */
.gallery.row,
.gallery.row > .column {
  padding: 8px;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  display: none; /* Hide all elements by default */
}

/* Clear floats after rows */ 
.gallery.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Content */
.content {
  background-color: white;
}


/* The "show" class is added to the filtered elements */
.show {
  display: block;
}

/* Style the buttons */
.gallery.btng {
  border: none;
  outline: none;
  padding: 10px 10px;
  cursor: pointer;
  color: black; 
  background-color: white;
  border-radius:0;
}

.gallery.btng:hover {
    background-color: none;
}

.gallery.btng.active {
  border-bottom: 3px solid #a39161;
  background-color: white;
  font-weight: 600;
}

.result-cards {
    margin-top:3rem;
}


.gallery.card {
  box-shadow: 0 4px 4px 4px rgba(0, 0, 0, 0.1), 0 4px 4px 0 rgba(0, 0, 0, 0.1);
  margin-left:10px;
  margin-top:10px;
  height:284px;
  display: inline-block;
    overflow: hidden;
}

.gallery.card:hover {
  box-shadow: 0 10px 10px 10px rgba(0, 0, 0, 0.1), 0 10px 10px 0 rgba(0, 0, 0, 0.1);
  margin-left:10px;
  margin-top:10px;
  height:284px;
  cursor:pointer;
}

.level {
    display: inline;
    margin-top: 8px;
    float:right;
}

.offering {
    float:left;
    display: inline;
    margin-top: 8px;
}

.offering span {
    text-transform:uppercase;
    letter-spacing: 2px;
    color: #383838;
    font-size:90%;

}

.level p {
    text-transform:capitalize;
    font-size:80%;
    display: inline;
    vertical-align: -12%;
    margin-left:3px;
}

.card-date {
    display: block;
    color:gray;
    font-size:90%;
    margin-top:-5px;
}

.gallery h4 {
    font-size:1.1rem;
    margin-top:5px;
}

.card-data {
    padding: 8px 8px 8px 8px;
}

.gallery.card:hover > img {
  width: 100%;
    transform: scale(1.05);
}

img { 
  -webkit-transition: all .4s ease-in-out;
  -moz-transition: all .4s ease-in-out;
  -o-transition: all .4s ease-in-out;
  -ms-transition: all .4s ease-in-out;
}



</style>
</head>


<!-- MAIN -->
<div class="main">

<div id="mybtngContainer" class="mb-3">
  <button class="gallery btng active" onclick="filterSelection('all')"> Show all</button>
  <button class="gallery btng" onclick="filterSelection('BRMP')"> BRMP</button>
  <button class="gallery btng" onclick="filterSelection('ITIL')"> ITIL</button>
  <button class="gallery btng" onclick="filterSelection('PRINCE2')"> PRINCE2</button>
  <button class="gallery btng" onclick="filterSelection('DevOps')"> DevOps</button>
  <button class="gallery btng" onclick="filterSelection('ISO')"> ISO 20000</button>
  <button class="gallery btng" onclick="filterSelection('CHAMP')"> CHAMP</button>
  <button class="gallery btng" onclick="filterSelection('CSAM')"> CSAM</button>
</div>

<!-- Portfolio Gallery Grid -->
<div class="row">
  <div class="column BRMP">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\brpm.png" width="100%">
    <div class="card-data"> 
      <h4 class="gallery">Business Relationship Management Professional - BRMP®</h4>
        <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>

    </div>
  </div>
  
  <div class="column ITIL">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\itil.png" width="100%"> 
    <div class="card-data">
      <h4>ITIL® Foundation - IT Service Management</h4>
      
        <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>

  </div>
  <div class="column ITIL">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\itil2.png" width="100%">
    <div class="card-data"> 
      <h4>ITIL® Intermediate - Planning, Protection & Optimization (PPO)</h4>
      <div class="level">
        <img src="../assets/img/icons/intermediate.svg" width="25px">
        <p>intermediate</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
</div>
  </div>


  <div class="column ITIL">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\itil3.png" width="100%">
    <div class="card-data"> 
      <h4>ITIL® Intermediate - Managing Across the Lifecycle (MALC)</h4>
      <div class="level">
      <img src="../assets/img/icons/intermediate.svg" width="25px">
        <p>intermediate</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>

  <div class="column PRINCE2">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\prince.png" width="100%">
    <div class="card-data"> 
      <h4>PRINCE2® Foundation</h4>
      <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>

  <div class="column PRINCE2">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\prince2.png" width="100%">
    <div class="card-data"> 
      <h4>PRINCE2® Practitioner</h4>
      <div class="level">
      <img src="../assets/img/icons/intermediate.svg" width="25px">
        <p>intermediate</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>
  

  <div class="column DevOps">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\devop.png" width="100%">
    <div class="card-data"> 
      <h4>DevOps Fundamentals</h4>
      <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>


  <div class="column DevOps">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\devop2.png" width="100%">
    <div class="card-data"> 
      <h4>DevOps Leadership</h4>
      <div class="level">
        <img src="../assets/img/icons/advanced.svg" width="25px">
        <p>advanced</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>

  <div class="column CHAMP">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\hardware.png" width="100%">
    <div class="card-data"> 
      <h4>Certified Hardware Asset Management Professional - CHAMP</h4>
      <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>


  <div class="column CSAM">
    <div class="content gallery card">
    <img src="..\assets\img\gallery\CSAM.png" width="100%">
    <div class="card-data"> 
      <h4>Certified Software Asset Manager - CSAM</h4>
      <div class="level">
        <img src="../assets/img/icons/beginner.svg" width="25px">
        <p>beginner</p>
        </div>
        
        <div class="offering">
        <span>next offering</span>
        <p class="card-date">Oct 5, 2021</p>
        </div>
    </div>
    </div>
  </div>

<!-- END GRID -->
<hr>
</div>

<!-- END MAIN -->
</div>

<script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btngContainer = document.getElementById("mybtngContainer");
var btngs = btngContainer.getElementsByClassName("btng");
for (var i = 0; i < btngs.length; i++) {
  btngs[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>

</div>
