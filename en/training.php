<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title> Training | Qualiti7 </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

	<!-- CSS here -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="../assets/css/slicknav.css">
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <link rel="stylesheet" href="../assets/css/gijgo.css">
	<link rel="stylesheet" href="../assets/css/animate.min.css">
	<link rel="stylesheet" href="../assets/css/magnific-popup.css">
	<link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="../assets/css/themify-icons.css">
	<link rel="stylesheet" href="../assets/css/slick.css">
	<link rel="stylesheet" href="../assets/css/nice-select.css">
	<link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/training.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>


<!-- Header Start -->
<?php include '../_includes/header_en.php';?>
<!-- Header End -->


    <main>
        <!--? Hero Start -->
        <div class="slider-area">
        <div class="slider-height2 d-flex align-items-center" style="background-image: url('../assets/img/hero/training.png');min-height:400px;">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center">
                                <h2>Training</h2>
                                <p class="text-light">Our vast catalog of training will provide you with the tools you need to succeed. Qualiti7 endeavors to deliver the professional IT training that you need to push your career to the next level.</p>
      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <?php
include('../admin/_adminincludes/db_connection.php');

$sql = "SELECT * FROM course";
$result = mysqli_query($connect, $sql);
$sqlForCategory = "SELECT * FROM category";
$resultForCategory = mysqli_query($connect, $sqlForCategory);
$sqlForLang = "SELECT * FROM language";
$resultForLang = mysqli_query($connect, $sqlForLang);


/* if (isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }
  $addSQL = 'INSERT INTO course(`category_id`, `language_id`, `course_name`, `course_syllabus`, `course_description`, `course_comment`, `course_createdat`, `course_difficulty`, `course_hasexam`) VALUES ("' . $copy['catID'] . '","' . $copy['langID'] . '","' . $copy['courseName'] . '","' . $copy['courseSyll'] . '","' . $copy['courseDesc'] . '","' . $copy['courseComm'] . '",CURRENT_DATE(),"' . $copy['courseDiff'] . '","' . $copy['hasExam'] . '")';
  if (mysqli_query($connect, $addSQL)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add ' . mysqli_error($connect);
  }
} */
?>
  </div>

  <!-- main content -->

  <div style="width:90%; margin:auto; min-width:600px">

  <div class="row top-content">
  <div class="col-3 pl-1">

  <h1>Choose a course</h1>

<form action="" method="POST">
  <select name="course" id="course">
  <option>All courses</option>
  <?php
  include('..admin/_adminincludes/db_connection.php'); 
  $sqli = "SELECT * FROM course";
  $result = mysqli_query($connect, $sqli);
  while ($row = mysqli_fetch_array($result)) {
    echo '<option>' .$row['course_name'].'</option>';
  }
  ?>
  </select>
  <br>

  <select name="language" id="language">
  <option>All languages</option>
  <?php
  include('..admin/_adminincludes/db_connection.php'); 
  $sqli = "SELECT * FROM course";
  $result = mysqli_query($connect, $sqli);
  $a=array();
  while ($row = mysqli_fetch_array($result)) {
    array_push($a,$row['course_language']);
  }
  $res=array_unique($a);
  foreach ($res as $value) {
    echo '<option>' . $value .'</option>';
  }
  
  ?>
  </select>
  <br>
  <select name="location" id="location">
  <option>All locations</option>
    <?php
    include('..admin/_adminincludes/db_connection.php'); 
    $sqli = "SELECT * FROM venue";
    $result = mysqli_query($connect, $sqli);
    while ($row = mysqli_fetch_array($result)) {
      echo '<option>' .$row['venue_city'].'</option>';
    }
    ?>
    <option>Online</option>
  </select>
  <br>

 
  <br><br>
  <div>

    <input class="btn btn-gold text-light text-uppercase lang" type="button" id="submitFormData" onclick="SubmitFormData();" value="Submit" />
  </div>
</form>



  </div>




  <div class="col-8 ml-5">
   <p>Thanks to the very high quality and extensive experience of our instructors, and our constant drive to improve our courses, Qualiti7 has developed agreements with a variety of partners to jointly offer IT management courses that allow businesses to achieve even greater productivity, demonstrating a clear commitment to quality and enjoying wide recognition on the training market.</p> 
  
   <div class="mt-5" style="margin-left:0rem">
  


<div class="col-sm-9 col-md-10 mt-5">
  
  <table class="table table-striped table-main">
  
    <thead>
    <p class="bg-dark text-white p-2 top-bar">List of Current Offerings</p>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Course Name</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody id="results">
    
    </tbody>
  </table>
</div>
</div>
</div>

  </div>
  </div>
  </div>
    </main>


<!-- Footer Start-->
<?php include '../_includes/footer_en.php';?>
<!-- Footer End -->



    <!-- Scroll Up -->
    <div id="back-top" >
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->

    <script src="../assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="../assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <!-- JQuery-->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="../assets/js/wow.min.js"></script>
    <script src="../assets/js/animated.headline.js"></script>
    <script src="../assets/js/jquery.magnific-popup.js"></script>

    <!-- Date Picker -->
    <script src="../assets/js/gijgo.min.js"></script>
    <!-- Nice-select, sticky -->
    <script src="../assets/js/jquery.nice-select.min.js"></script>
    <script src="../assets/js/jquery.sticky.js"></script>
    
    <!-- counter , waypoint -->
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <script src="../assets/js/waypoints.min.js"></script>
    
    <!-- contact js -->
    <script src="../assets/js/contact.js"></script>
    <script src="../assets/js/jquery.form.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="../assets/js/mail-script.js"></script>
    <script src="../assets/js/jquery.ajaxchimp.min.js"></script>
    
    <!-- Jquery Plugins, main Jquery -->	
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>

    <script src="../assets/js/submit.js"></script>
    
    </body>
</html>