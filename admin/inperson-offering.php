<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM in_person_offering";
$sqlForCourse = "SELECT * FROM course";
$resultForCourse = mysqli_query($connect, $sqlForCourse);
$sqlForVenue = "SELECT * FROM venue";
$resultForVenue = mysqli_query($connect, $sqlForVenue);
$sqlForTrainer = "SELECT * FROM staff NATURAL JOIN staff_has_role NATURAL JOIN role WHERE role_name = 'trainer'";
$resultForTrainer = mysqli_query($connect, $sqlForTrainer);
$result = mysqli_query($connect, $sql);


// PHP for delete Offering
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $name=$_POST['name'];
  $sql_delete = "DELETE FROM in_person_offering WHERE in_person_offering_id='$id';";
  $result_delete = mysqli_query($connect, $sql_delete);
  if($result_delete) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Offering '$name' has been deleted";
    $_SESSION['msg_type'] = "danger";
    exit();    
  } 
  else {
    echo 'Failed to delete' . mysqli_error($connect);
  }
}

// PHP for confirmation
if(isset($_POST['isConfirmed?'])) {
  if($_POST['isConfirmed?'] == 'Unconfirm') {
    $value = 0;
  } else {
    $value = 1;
  }

  if (mysqli_query($connect, 'UPDATE in_person_offering SET offering_isconfirmed ='.$value.' WHERE in_person_offering_id =' .$_POST['id'])) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
}


// PHP for edit Domain
if (isset($_POST['update'])) {
  //escaping string for safety
  $id=$_POST['id'];
  $course_id=$_POST['courseID'];
  $trainer_id=$_POST['trainerID'];
  $venue_id=$_POST['venueID'];
  $offering_startdate=$_POST['stDate'];
  $offering_enddate=$_POST['endDate'];
  $offering_starttime=$_POST['stTime'];
  $offering_endtime=$_POST['endTime'];
  $offering_timezone=$_POST['timezone'];
  $offering_price=$_POST['price'];
  $offering_isprivate=$_POST['priOrNot'];

 $sql_update = "UPDATE in_person_offering SET course_id='$course_id', trainer_id='$trainer_id', venue_id='$venue_id', offering_startdate='$offering_startdate', offering_enddate='$offering_enddate', offering_starttime='$offering_starttime', offering_endtime='$offering_endtime', offering_timezone='$offering_timezone', offering_price='$offering_price', offering_isprivate='$offering_isprivate' WHERE in_person_offering_id='$id';";

  $result_update = mysqli_query($connect, $sql_update);
  if($result_update) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Offering updated successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
  }    
  else {
    echo 'Failed to update' . mysqli_error($connect);
  }
}



if (isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);  
  }
  $insert = 'INSERT INTO in_person_offering (`course_id`, `trainer_id`, `venue_id`, `offering_startdate`, `offering_enddate`, `offering_starttime`, `offering_endtime`, `offering_timezone`, `offering_price`, `offering_isprivate`)VALUES ("'  . $_POST['courseID'] . '","' . $copy['trainerID'] . '","' . $copy['venueID'] . '","' . $copy['stDate'] . '","' . $copy['endDate'] . '","' . $copy['stTime'] .':00'. '","' . $copy['endTime'].':00' . '","' . $_POST['timezone']. '","' . $copy['price'] . '","' . $copy['priOrNot'] .'")';
  if (mysqli_query($connect, $insert)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Offering added successfully";
    $_SESSION['msg_type'] = "success";
    exit(); 
    echo "<meta http-equiv='refresh' content='0'>"; // form refresh code
  } else {
    echo 'Failed to add ' . mysqli_error($connect);
  }
}
?>

<div class="col-sm-9 col-md-10 mt-3">
<?php
// Set session variables
if(isset($_SESSION['status']))
{
  ?>

  <div class="alert alert-<?php echo $_SESSION['msg_type'] ?>" role="alert" id="success-alert">
  <?php echo $_SESSION['status']; ?>
  </div>

  <?php
  unset($_SESSION['status']);
}
?>
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-building"></i> In-Person Offerings</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Course Name</th>
        <th scope="col">Trainer Name</th>
        <th scope="col">Venue Name</th>
        <th scope="col">From - to dates</th>
        <th scope="col">Timings</th>
        <th scope="col">Price</th>
        <th scope="col">Private?</th>
        <th scope="col">Enrollments</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $index = 1;
      while ($row = mysqli_fetch_array($result)) {
       
        $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCourse . ' where course_id = ' . $row['course_id']));
        if ($row['offering_isprivate'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }
        $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForTrainer . ' AND staff_id = ' . $row['trainer_id']));
        $row4 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForVenue . ' where venue_id = ' . $row['venue_id']));
        $row5 = mysqli_fetch_assoc(mysqli_query($connect, 'SELECT COUNT(*) FROM in_person_enrollment where in_person_offering_id = ' . $row['in_person_offering_id']));

        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['course_name'] . '</td>            
              <td>' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</td>            
              <td>' . $row4['venue_streetaddress'].', '.$row4['venue_city'] . '</td>            
              <td>' . $row['offering_startdate'] . ' - ' . $row['offering_enddate'] . '</td>            
              <td>' . $row['offering_starttime'] . ' - ' . $row['offering_endtime'] .' '. $row['offering_timezone'] . '</td>            
              <td>' . $row['offering_price'] . '</td>            
              <td>' . $b . '</td>            
              <td>' . $row5['COUNT(*)'] . '</td>
              <td>
                <div>
                <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-name="' . $row2['course_name'] . '" data-courseid="' . $row2['course_id'] . '" data-inperson="' . $b . '" data-trainer="' . $row3['staff_id'] . '" data-venue="' . $row4['venue_id'] . '" data-startdate="' . $row['offering_startdate'] . '" data-enddate="' . $row['offering_enddate'] . '" data-starttime="' . $row['offering_starttime'] . '" data-endtime="' . $row['offering_endtime'] . '" data-timezone="' . $row['offering_timezone'] . '" data-price="' . $row['offering_price'] . '" data-id="' . $row['in_person_offering_id'] . '"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['in_person_offering_id'] . '" del-name="' . $row2['course_name']  . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              
                </div>
                <div>
                  <form action="" method="POST">
                    <input type="hidden" name="id" value='.$row['in_person_offering_id'].'>';

                    if($row['offering_isconfirmed']) {
                      echo '<input class="btn btn-outline-danger d-block mt-2 btn-sm" name="isConfirmed?" type="Submit" value="Unconfirm">';
                    } else {
                      echo '<input class="btn btn-outline-success d-block mt-2 btn-sm" name="isConfirmed?" type="Submit" value="Confirm">';
                    }
                  echo '</form>';
              
              echo '</div>
              <div class="mt-2"><a class="btn btn-outline-primary btn-sm" href="'.'inperson-enrollment.php'.'?IoID='.$row['in_person_offering_id'].'" target="_blank">See enrollments</a></div></td>
              </tr>';
        $index++;
      }
      ?>
    </tbody>
  </table>
  <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Offering</button>
</div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="addOffering" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addOfferingHeader">Add Offering</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="mainForm"  action="" method="POST">
        <input type="hidden" name="id" id="in_person_id" value="">
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <select class="form-select" name="courseID" id="courseID" required>
              <option value="" selected disabled>Course Name</option>
              <?php
              while ($row2 = mysqli_fetch_assoc($resultForCourse)) {
                echo '<option value="' . $row2['course_id'] . '">' . $row2['course_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Name</label>
            <select class="form-select" name="trainerID" id="trainerID" required>
              <option value="" selected disabled>Trainer Name</option>
              <?php
              while ($row3 = mysqli_fetch_assoc($resultForTrainer)) {
                echo '<option value="' . $row3['staff_id'] . '">' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Name</label>
            <select class="form-select" name="venueID" id="venueID" required>
              
              <?php
              if(mysqli_num_rows($resultForVenue) > 0) {
                echo '<option value="" selected disabled>Venue Name</option>';
                while ($row4 = mysqli_fetch_assoc($resultForVenue)) {
                  echo '<option value="' . $row4['venue_id'] . '">' . $row4['venue_streetaddress'].', '.$row4['venue_city'] . '</option>';
                }
              } else {
                echo '<option value="" selected disabled>Please Add Some Venues First</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Start date</label>
            <input type="date" class="form-control" id="stDate" name="stDate" />
          </div>
          <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate" />
          </div>
          <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="text" class="form-control" id="stTime" name="stTime" placeholder="24H format HH:MM"/>
          </div>
          <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="text" class="form-control" id="endTime" name="endTime" placeholder="24H format HH:MM"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Offering Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Price" />
          </div>
          <div class="mb-3">
            <label class="form-label">Timezone</label>
            <select class="form-select" name="timezone" id="timezone">
              <option value="" selected disabled>Choose a Timezone</option>
              <option value="A">A - Alpha Time Zone</option>
              <option value="ACDT">ACDT - Australian Central Daylight Time</option>
              <option value="ACST">ACST - Australian Central Standard Time</option>
              <option value="ACT">ACT - Acre Time</option>
              <option value="ACT">ACT - Australian Central Time</option>
              <option value="ACWST">ACWST - Australian Central Western Standard Time</option>
              <option value="ADT">ADT - Arabia Daylight Time</option>
              <option value="ADT">ADT - Arabian Daylight Time</option>
              <option value="ADT">ADT - Atlantic Daylight Time</option>
              <option value="AEDT">AEDT - Australian Eastern Daylight Time</option>
              <option value="AEST">AEST - Australian Eastern Standard Time</option>
              <option value="AET">AET - Australian Eastern Time</option>
              <option value="AFT">AFT - Afghanistan Time</option>
              <option value="AKDT">AKDT - Alaska Daylight Time</option>
              <option value="AKST">AKST - Alaska Standard Time</option>
              <option value="ALMT">ALMT - Alma-Ata Time</option>
              <option value="AMST">AMST - Amazon Summer Time</option>
              <option value="AMST">AMST - Armenia Summer Time</option>
              <option value="AMT">AMT - Amazon Time</option>
              <option value="AMT">AMT - Armenia Time</option>
              <option value="ANAST">ANAST - Anadyr Summer Time</option>
              <option value="ANAT">ANAT - Anadyr Time</option>
              <option value="AQTT">AQTT - Aqtobe Time</option>
              <option value="ART">ART - Argentina Time</option>
              <option value="AST">AST - Arabia Standard Time</option>
              <option value="AST">AST - Arabian Standard Time</option>
              <option value="AST">AST - Atlantic Standard Time</option>
              <option value="AT">AT - Atlantic Time</option>
              <option value="AWDT">AWDT - Australian Western Daylight Time</option>
              <option value="AWST">AWST - Australian Western Standard Time</option>
              <option value="AZOST">AZOST - Azores Summer Time</option>
              <option value="AZOT">AZOT - Azores Time</option>
              <option value="AZST">AZST - Azerbaijan Summer Time</option>
              <option value="AZT">AZT - Azerbaijan Time</option>
              <option value="AoE">AoE - Anywhere on Earth</option>
              <option value="B">B - Bravo Time Zone</option>
              <option value="BNT">BNT - Brunei Darussalam Time</option>
              <option value="BOT">BOT - Bolivia Time</option>
              <option value="BRST">BRST - Brasília Summer Time</option>
              <option value="BRT">BRT - Brasília Time</option>
              <option value="BRT">BRT - Brasilia Time</option>
              <option value="BST">BST - Bangladesh Standard Time</option>
              <option value="BST">BST - Bougainville Standard Time</option>
              <option value="BST">BST - British Summer Time</option>
              <option value="BTT">BTT - Bhutan Time</option>
              <option value="C">C - Charlie Time Zone</option>
              <option value="CAST">CAST - Casey Time</option>
              <option value="CAT">CAT - Central Africa Time</option>
              <option value="CCT">CCT - Cocos Islands Time</option>
              <option value="CDT">CDT - Central Daylight Time</option>
              <option value="CDT">CDT - Cuba Daylight Time</option>
              <option value="CEST">CEST - Central European Summer Time</option>
              <option value="CET">CET - Central European Time</option>
              <option value="CHADT">CHADT - Chatham Island Daylight Time</option>
              <option value="CHAST">CHAST - Chatham Island Standard Time</option>
              <option value="CHOST">CHOST - Choibalsan Summer Time</option>
              <option value="CHOT">CHOT - Choibalsan Time</option>
              <option value="CHUT">CHUT - Chuuk Time</option>
              <option value="CIDST">CIDST - Cayman Islands Daylight Saving Time</option>
              <option value="CIST">CIST - Cayman Islands Standard Time</option>
              <option value="CKT">CKT - Cook Island Time</option>
              <option value="CKT">CKT - Cook Islands Time</option>
              <option value="CLST">CLST - Chile Summer Time</option>
              <option value="CLT">CLT - Chile Standard Time</option>
              <option value="COT">COT - Colombia Time</option>
              <option value="CST">CST - Central Standard Time</option>
              <option value="CST">CST - China Standard Time</option>
              <option value="CST">CST - Cuba Standard Time</option>
              <option value="CT">CT - Central Time</option>
              <option value="CVT">CVT - Cape Verde Time</option>
              <option value="CXT">CXT - Christmas Island Time</option>
              <option value="ChST">ChST - Chamorro Standard Time</option>
              <option value="D">D - Delta Time Zone</option>
              <option value="DAVT">DAVT - Davis Time</option>
              <option value="DDUT">DDUT - Dumont-d'Urville Time</option>
              <option value="E">E - Echo Time Zone</option>
              <option value="EASST">EASST - Easter Island Summer Time</option>
              <option value="EAST">EAST - Easter Island Standard Time</option>
              <option value="EAT">EAT - Eastern Africa Time</option>
              <option value="EAT">EAT - East Africa Time</option>
              <option value="ECT">ECT - Ecuador Time</option>
              <option value="EDT">EDT - Eastern Daylight Time</option>
              <option value="EEST">EEST - Eastern European Summer Time</option>
              <option value="EET">EET - Eastern European Time</option>
              <option value="EGST">EGST - Eastern Greenland Summer Time</option>
              <option value="EGT">EGT - East Greenland Time</option>
              <option value="EST">EST - Eastern Standard Time</option>
              <option value="ET">ET - Eastern Time</option>
              <option value="F">F - Foxtrot Time Zone</option>
              <option value="FET">FET - Further-Eastern European Time</option>
              <option value="FJST">FJST - Fiji Summer Time</option>
              <option value="FJT">FJT - Fiji Time</option>
              <option value="FKST">FKST - Falkland Islands Summer Time</option>
              <option value="FKT">FKT - Falkland Island Time</option>
              <option value="FKT">FKT - Falkland Islands Time</option>
              <option value="FNT">FNT - Fernando de Noronha Time</option>
              <option value="G">G - Golf Time Zone</option>
              <option value="GALT">GALT - Galapagos Time</option>
              <option value="GAMT">GAMT - Gambier Time</option>
              <option value="GET">GET - Georgia Standard Time</option>
              <option value="GFT">GFT - French Guiana Time</option>
              <option value="GILT">GILT - Gilbert Island Time</option>
              <option value="GMT">GMT - Greenwich Mean Time</option>
              <option value="GST">GST - Gulf Standard Time</option>
              <option value="GST">GST - South Georgia Time</option>
              <option value="GYT">GYT - Guyana Time</option>
              <option value="H">H - Hotel Time Zone</option>
              <option value="HDT">HDT - Hawaii-Aleutian Daylight Time</option>
              <option value="HKT">HKT - Hong Kong Time</option>
              <option value="HOVST">HOVST - Hovd Summer Time</option>
              <option value="HOVT">HOVT - Hovd Time</option>
              <option value="HST">HST - Hawaii Standard Time</option>
              <option value="HST">HST - Hawaii-Aleutian Standard Time</option>
              <option value="I">I - India Time Zone</option>
              <option value="ICT">ICT - Indochina Time</option>
              <option value="IDT">IDT - Israel Daylight Time</option>
              <option value="IOT">IOT - Indian Chagos Time</option>
              <option value="IRDT">IRDT - Iran Daylight Time</option>
              <option value="IRKST">IRKST - Irkutsk Summer Time</option>
              <option value="IRKT">IRKT - Irkutsk Time</option>
              <option value="IRST">IRST - Iran Standard Time</option>
              <option value="IST">IST - India Standard Time</option>
              <option value="IST">IST - Irish Standard Time</option>
              <option value="IST">IST - Israel Standard Time</option>
              <option value="JST">JST - Japan Standard Time</option>
              <option value="K">K - Kilo Time Zone</option>
              <option value="KGT">KGT - Kyrgyzstan Time</option>
              <option value="KOST">KOST - Kosrae Time</option>
              <option value="KRAST">KRAST - Krasnoyarsk Summer Time</option>
              <option value="KRAT">KRAT - Krasnoyarsk Time</option>
              <option value="KST">KST - Korea Standard Time</option>
              <option value="KUYT">KUYT - Kuybyshev Time</option>
              <option value="L">L - Lima Time Zone</option>
              <option value="LHDT">LHDT - Lord Howe Daylight Time</option>
              <option value="LHST">LHST - Lord Howe Standard Time</option>
              <option value="LINT">LINT - Line Islands Time</option>
              <option value="M">M - Mike Time Zone</option>
              <option value="MAGST">MAGST - Magadan Summer Time</option>
              <option value="MAGT">MAGT - Magadan Time</option>
              <option value="MART">MART - Marquesas Time</option>
              <option value="MAWT">MAWT - Mawson Time</option>
              <option value="MDT">MDT - Mountain Daylight Time</option>
              <option value="MHT">MHT - Marshall Islands Time</option>
              <option value="MMT">MMT - Myanmar Time</option>
              <option value="MSD">MSD - Moscow Daylight Time</option>
              <option value="MSK">MSK - Moscow Standard Time</option>
              <option value="MST">MST - Mountain Standard Time</option>
              <option value="MT">MT - Mountain Time</option>
              <option value="MUT">MUT - Mauritius Time</option>
              <option value="MVT">MVT - Maldives Time</option>
              <option value="MYT">MYT - Malaysia Time</option>
              <option value="N">N - November Time Zone</option>
              <option value="NCT">NCT - New Caledonia Time</option>
              <option value="NDT">NDT - Newfoundland Daylight Time</option>
              <option value="NFDT">NFDT - Norfolk Daylight Time</option>
              <option value="NFT">NFT - Norfolk Time</option>
              <option value="NOVST">NOVST - Novosibirsk Summer Time</option>
              <option value="NOVT">NOVT - Novosibirsk Time</option>
              <option value="NPT">NPT - Nepal Time</option>
              <option value="NRT">NRT - Nauru Time</option>
              <option value="NST">NST - Newfoundland Standard Time</option>
              <option value="NUT">NUT - Niue Time</option>
              <option value="NZDT">NZDT - New Zealand Daylight Time</option>
              <option value="NZST">NZST - New Zealand Standard Time</option>
              <option value="O">O - Oscar Time Zone</option>
              <option value="OMSST">OMSST - Omsk Summer Time</option>
              <option value="OMST">OMST - Omsk Standard Time</option>
              <option value="ORAT">ORAT - Oral Time</option>
              <option value="P">P - Papa Time Zone</option>
              <option value="PDT">PDT - Pacific Daylight Time</option>
              <option value="PET">PET - Peru Time</option>
              <option value="PETST">PETST - Kamchatka Summer Time</option>
              <option value="PETT">PETT - Kamchatka Time</option>
              <option value="PGT">PGT - Papua New Guinea Time</option>
              <option value="PHOT">PHOT - Phoenix Island Time</option>
              <option value="PHT">PHT - Philippine Time</option>
              <option value="PKT">PKT - Pakistan Standard Time</option>
              <option value="PMDT">PMDT - Pierre & Miquelon Daylight Time</option>
              <option value="PMST">PMST - Pierre & Miquelon Standard Time</option>
              <option value="PONT">PONT - Pohnpei Standard Time</option>
              <option value="PST">PST - Pacific Standard Time</option>
              <option value="PST">PST - Pitcairn Standard Time</option>
              <option value="PT">PT - Pacific Time</option>
              <option value="PWT">PWT - Palau Time</option>
              <option value="PYST">PYST - Paraguay Summer Time</option>
              <option value="PYT">PYT - Paraguay Time</option>
              <option value="PYT">PYT - Pyongyang Time</option>
              <option value="Q">Q - Quebec Time Zone</option>
              <option value="QYZT">QYZT - Qyzylorda Time</option>
              <option value="R">R - Romeo Time Zone</option>
              <option value="RET">RET - Reunion Time</option>
              <option value="RET">RET - Réunion Time</option>
              <option value="ROTT">ROTT - Rothera Time</option>
              <option value="S">S - Sierra Time Zone</option>
              <option value="SAKT">SAKT - Sakhalin Time</option>
              <option value="SAMT">SAMT - Samara Time</option>
              <option value="SAST">SAST - South Africa Standard Time</option>
              <option value="SBT">SBT - Solomon Islands Time</option>
              <option value="SCT">SCT - Seychelles Time</option>
              <option value="SGT">SGT - Singapore Time</option>
              <option value="SRET">SRET - Srednekolymsk Time</option>
              <option value="SRT">SRT - Suriname Time</option>
              <option value="SST">SST - Samoa Standard Time</option>
              <option value="SYOT">SYOT - Syowa Time</option>
              <option value="T">T - Tango Time Zone</option>
              <option value="TAHT">TAHT - Tahiti Time</option>
              <option value="TFT">TFT - French Southern and Antarctic Time</option>
              <option value="TFT">TFT - French Southern & Antarctic Time</option>
              <option value="TJT">TJT - Tajikistan Time</option>
              <option value="TKT">TKT - Tokelau Time</option>
              <option value="TLT">TLT - East Timor Time</option>
              <option value="TMT">TMT - Turkmenistan Time</option>
              <option value="TOST">TOST - Tonga Summer Time</option>
              <option value="TOT">TOT - Tonga Time</option>
              <option value="TRT">TRT - Turkey Time</option>
              <option value="TVT">TVT - Tuvalu Time</option>
              <option value="U">U - Uniform Time Zone</option>
              <option value="ULAST">ULAST - Ulaanbaatar Summer Time</option>
              <option value="ULAT">ULAT - Ulaanbaatar Time</option>
              <option value="UTC">UTC - Coordinated Universal Time</option>
              <option value="UYST">UYST - Uruguay Summer Time</option>
              <option value="UYT">UYT - Uruguay Time</option>
              <option value="UZT">UZT - Uzbekistan Time</option>
              <option value="V">V - Victor Time Zone</option>
              <option value="VET">VET - Venezuelan Standard Time</option>
              <option value="VET">VET - Venezuela Standard Time</option>
              <option value="VLAST">VLAST - Vladivostok Summer Time</option>
              <option value="VLAT">VLAT - Vladivostok Time</option>
              <option value="VOST">VOST - Vostok Time</option>
              <option value="VUT">VUT - Vanuatu Time</option>
              <option value="W">W - Whiskey Time Zone</option>
              <option value="WAKT">WAKT - Wake Time</option>
              <option value="WARST">WARST - Western Argentine Summer Time</option>
              <option value="WAST">WAST - West Africa Summer Time</option>
              <option value="WAT">WAT - West Africa Time</option>
              <option value="WEST">WEST - Western European Summer Time</option>
              <option value="WET">WET - Western European Time</option>
              <option value="WFT">WFT - Wallis and Futuna Time</option>
              <option value="WGST">WGST - Western Greenland Summer Time</option>
              <option value="WGT">WGT - West Greenland Time</option>
              <option value="WIB">WIB - Western Indonesian Time</option>
              <option value="WIT">WIT - Eastern Indonesian Time</option>
              <option value="WITA">WITA - Central Indonesian Time</option>
              <option value="WITA">WITA - Central Indonesia Time</option>
              <option value="WST">WST - West Samoa Time</option>
              <option value="WST">WST - Western Sahara Summer Time</option>
              <option value="WT">WT - Western Sahara Standard Time</option>
              <option value="X">X - X-ray Time Zone</option>
              <option value="Y">Y - Yankee Time Zone</option>
              <option value="YAKST">YAKST - Yakutsk Summer Time</option>
              <option value="YAKT">YAKT - Yakutsk Time</option>
              <option value="YAPT">YAPT - Yap Time</option>
              <option value="YEKST">YEKST - Yekaterinburg Summer Time</option>
              <option value="YEKT">YEKT - Yekaterinburg Time</option>
              <option value="Z">Z - Zulu Time Zone</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Is it a Private Training</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot1" value="1" required>
              <label class="form-check-label" for="priOrNot1">
                Yes
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot2" value="0" required>
              <label class="form-check-label" for="priOrNot2">
                No
              </label>
            </div>
          </div>
            <input class="btn btn-gold text-light d-block ms-auto" name="submit" type="submit" id="submit" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>


   
<!------ Modal for confirm delete -------> 

<!-- Modal HTML -->
<div id="confirm" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">	
				<h4 class="modal-title w-100">Are you sure?</h4>	
        <button type="button" class="close btn-close" id="close-modal" aria-label="Close" onclick="$('#confirm').modal('hide');"></button>
			</div>
      <form id="deleteForm" action="" method="POST">
      <input type="hidden" name="id" id="offering_del_id" value="">
      <input type="hidden" name="name" id="offering_name" value="">
			<div class="modal-body">
				<p>Do you really want to delete the record "<span id="offering_del_name"></span>"? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" onclick="$('#confirm').modal('hide');">Cancel</button>
				<input id="delete" name="delete" class="btn btn-danger ms-auto" type="submit" value="Delete">
			</div>
      </form>
	</div>
</div>    

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
/* function for EDIT ROW
domain owner not filled
*/
$( ".edit" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// get data from edit button object

  var name = $(this).attr('data-name');
  var venue = $(this).attr('data-venue');
  var nameid = $(this).attr('data-courseid');
  var trainer = $(this).attr('data-trainer');
  var startdate = $(this).attr('data-startdate');
  var enddate = $(this).attr('data-enddate');
  var starttime = $(this).attr('data-starttime');
  var endtime = $(this).attr('data-endtime');
  var timezone = $(this).attr('data-timezone');
  var price = $(this).attr('data-price');
  var id = $(this).attr('data-id');
  var inperson = $(this).attr('data-inperson');


// set values on form
  $('#courseID').val(nameid);
  $('#trainerID').val(trainer);
  $('#venueID').val(venue);
  $('#stDate').val(startdate);
  $('#endDate').val(enddate);
  $('#stTime').val(starttime);
  $('#endTime').val(endtime);
  $('#timezone').val(timezone);
  $('#price').val(price);
  $('#in_person_id').val(id);
  
  if (inperson=="Yes") {
    $("#priOrNot1").prop("checked", true);
  }
  else {
    $("#priOrNot2").prop("checked", true);
  }



// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update Offering");
// change form header
  $("#addOfferingheader").html("Edit Offering");
// open form
  $('#addOffering').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addOfferingheader").html("Add Offering");
// open form
  $('#addOffering').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  var name = $(this).attr('del-name');
  $('#offering_del_id').val(id);
  $('#offering_name').val(name);
  $('#offering_name').html(name);
// open form to confirm delete
  $('#confirm').modal('show');
});

// function for success alert fadeout
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

</script>



<?php
include('_adminincludes/footer.php')
?>