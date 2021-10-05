<?php
include('../admin/_adminincludes/db_connection.php');

$course_sel = $_POST['course'];
$language_sel = $_POST['language'];
$location_sel = $_POST['location'];

$sqlForCourse = "SELECT * FROM course";
$resultForCourse = mysqli_query($connect, $sqlForCourse);

$sqlForVenue = "SELECT * FROM venue";
$resultForVenue = mysqli_query($connect, $sqlForVenue);


$sql_new = "SELECT course_id FROM online_offering";
$sql_course = "SELECT course_id, course_name FROM course";

$sql_offerings =  "(SELECT 'Online' AS Type, course_id, Null as venue_id, offering_startdate, offering_timezone
FROM online_offering)

UNION
(SELECT 'Partner', course_id, Null as venue_id, offering_startdate, offering_timezone
FROM partner_offering)

UNION
(SELECT 'In Person', course_id, venue_id, offering_startdate, offering_timezone
FROM in_person_offering)
ORDER BY offering_startdate";

$result_new = mysqli_query($connect, $sql_offerings);

$ind = 0;

while ($row = mysqli_fetch_array($result_new)) {

    $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCourse . ' where course_id = ' . $row['course_id']));
    //echo '<pre>'; print_r($row2); echo '</pre>';
    //echo $language_sel;

    if ($row['venue_id']) {
      $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForVenue . ' where venue_id = ' . $row['venue_id']));
      $city = $row3['venue_state'];
    }
    else {
      $city = "Online";
      $row3 = "Online";
    }

    if ($row2['course_language'] == "fr") {
      $lang = "French";
    }
    
    if ($row2['course_language'] == "en") {
      $lang = "English";
    }



    $trow = '<tr>
    <td>' . $row['offering_startdate'] . '</td> 
    <td><b>' . $row2['course_name'] . '</b><br><span>' . $lang . ' – ' . $city . ' - ' . $row['offering_timezone'] . '</span></td>                         
    <td><a href="#"><div class="mt-2 text-dark">See details +</div></a></td>
    </tr>';

    $cond1 = ($course_sel==$row2['course_name'] || $course_sel=="All courses");
    $cond2 = $language_sel==$row2['course_language'] || $language_sel=="All languages";
    //$cond3 = $location_sel==$row3['venue_state'] || $location_sel=="All locations" || $row3=="Online";

    

    if ($cond1 && $cond2) {
        echo $trow;
        $ind++;
    }

  }

  if ($ind==0) {
      echo "No course found";
  }



?>