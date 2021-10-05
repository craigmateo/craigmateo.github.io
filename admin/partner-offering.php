<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM partner_offering";
$sqlForCourse = "SELECT * FROM course";
$resultForCourse = mysqli_query($connect, $sqlForCourse);
$sqlForTrainer = "SELECT * FROM staff NATURAL JOIN staff_has_role NATURAL JOIN role WHERE role_name = 'trainer'";
$resultForTrainer = mysqli_query($connect, $sqlForTrainer);
$sqlForPartner = "SELECT * FROM partner";
$resultForPartner = mysqli_query($connect, $sqlForPartner);
$result = mysqli_query($connect, $sql);
if (isset($_GET['id'])) {
  if (mysqli_query($connect, 'DELETE FROM partner_offering WHERE partner_offering_id =' . $_GET['id'])) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}

if (isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }

  //echo '<pre>'; print_r($copy); echo '</pre>';

  $insert = 'INSERT INTO partner_offering (`course_id`, `trainer_id`, `partner_id`, `partner_url`, `offering_isonline`, `offering_startdate`, `offering_enddate`, `offering_starttime`,  `offering_endtime`) VALUES ("'. $copy['courseID'] . '","' . $copy['trainer_id'] . '","' . $copy['partID'] . '","' . $copy['URL'] . '","' . $copy['isOnline'] . '","' . $copy['stDate'] .'","' . $copy['endDate'] . '","' . $copy['stTime'] .':00'. '","' . $copy['endTime'].':00")';
  if (mysqli_query($connect, $insert)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    echo "<meta http-equiv='refresh' content='0'>"; // form refresh code
  } else {
    echo 'Failed to add ' . mysqli_error($connect);
  }
}
?>

<div class="col-sm-9 col-md-10 mt-3">
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-users"></i> Partner Offerings</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Course Name</th>
        <th scope="col">Trainer Name</th>
        <th scope="col">Partner Name</th>
        <th scope="col">Partner URL</th>
        <th scope="col">Online?</th>
        <th scope="col">From - to dates</th>
        <th scope="col">Timings</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 1;
      while ($row = mysqli_fetch_array($result)) {
        $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCourse . ' where course_id = ' . $row['course_id']));
        if ($row['offering_isonline'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }

        $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForTrainer . ' AND staff_id = ' . $row['trainer_id']));
        //echo '<pre>'; print_r($row3); echo '</pre>';
    

        $row4 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForPartner . ' where partner_id = ' . $row['partner_id']));
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['course_name'] . '</td>            
              <td>' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</td>            
              <td>' . $row4['partner_name'] . '</td>            
              <td><a target="_blank" type="button" class="btn link-button" href="' . $row['partner_url'] . '"' . 'title="' . $row['partner_url'] . '">Link&nbsp;</a></td>            
              <td>' . $b . '</td>            
              <td>' . $row['offering_startdate'] . ' - ' . $row['offering_enddate'] . '</td>            
              <td>' . $row['offering_starttime'] . ' - ' . $row['offering_endtime'] . '</td>            
              <td><a class="delete" href="' . $_SERVER['PHP_SELF'] . '?id=' . $row['partner_offering_id'] . '" title="Delete row"><img src="..\assets\img\icons\delete.svg"></a></td>
              </tr>';
              $index++;
      }
      ?>
    </tbody>
  </table>
</div>
</div>
<div>
  <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addOffering">+</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addOffering" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Offering</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <select class="form-select" name="courseID">
              <option selected disabled>Course Name</option>
              <?php
              while ($row2 = mysqli_fetch_assoc($resultForCourse)) {
                echo '<option value="' . $row2['course_id'] . '">' . $row2['course_name'] . '</option>';
              } ?>
            </select>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Trainer Name</label>
            <select class="form-select" name="trainer_id">
              <option selected disabled>Trainer Name</option>
              <?php
              while ($row3 = mysqli_fetch_assoc($resultForTrainer)) {
                echo '<option value="' . $row3['staff_id'] . '">' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Partner Name</label>
            <select class="form-select" name="partID">
              <option selected disabled>Partner Name</option>
              <?php
              while ($row4 = mysqli_fetch_assoc($resultForPartner)) {
                echo '<option value="' . $row4['partner_id'] . '">' . $row4['partner_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Course URL</label>
            <input type="text" class="form-control" id="URL" name="URL" placeholder="URL of the course on partner's site" />
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
            <label class="form-label">Is it a Online Training?</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="isOnline" id="isOnline1" value="1">
              <label class="form-check-label" for="isOnline1">
                Yes
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="isOnline" id="isOnline2" value="0">
              <label class="form-check-label" for="isOnline2">
                No
              </label>
            </div>
            <input class="btn btn-success d-block ms-auto" name="submit" type="Submit" value="Submit">
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include('_adminincludes/footer.php')
?>