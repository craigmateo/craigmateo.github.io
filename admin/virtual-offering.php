<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM virtual_offering";
$sqlForCourse = "SELECT * FROM course";
$resultForCourse = mysqli_query($connect, $sqlForCourse);
$sqlForTrainer = "SELECT * FROM staff NATURAL JOIN staff_has_role NATURAL JOIN role WHERE role_name = 'trainer'";
$resultForTrainer = mysqli_query($connect, $sqlForTrainer);
$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM virtual_offering WHERE virtual_offering_id ='.$_GET['id'])) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}

if(isset($_POST['isConfirmed?'])) {
  if($_POST['isConfirmed?'] == 'Unconfirm') {
    $value = 0;
  } else {
    $value = 1;
  }

  if (mysqli_query($connect, 'UPDATE virtual_offering SET offering_isconfirmed ='.$value.' WHERE virtual_offering_id =' .$_POST['id'])) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
}

if(isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);  
  }
  $insert = 'INSERT INTO virtual_offering(`course_id`, `trainer_id`, `offering_price`, `offering_isprivate`, `offering_video_link`) VALUES ("'.$copy['courseID'].'","'.$copy['trainerID'].'","'.$copy['price'].'","'.$copy['vidLink'].'","'.$copy['offeringRelDate'].'")';
  if(mysqli_query($connect, $insert)) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
    echo "<meta http-equiv='refresh' content='0'>"; // form refresh code
  } else {
    echo 'Failed to add'. mysqli_error($connect);
  }  
}
?>

<div class="col-sm-9 col-md-10 mt-3">
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-desktop"></i> Virtual Offerings</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>         
              <th scope="col">Course Name</th>
              <th scope="col">Trainer Name</th>
              <th scope="col">Price</th>
              <th scope="col">Videos Link</th>
              <th scope="col">Private?</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              
              $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCourse.' where course_id = '.$row['course_id'])); 
              $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForTrainer . ' AND staff_id = ' . $row['trainer_id'])); 
              if ($row['offering_isprivate'] == 1) {
                $b = "Yes";
              } else {
                $b = "No";
              }
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['course_name'] . '</td>            
              <td>' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</td>           
              <td>' . $row['offering_price'] . '</td>            
              <td>' . $row['offering_video_link'] . '</td>            
              <td>' . $row['offering_isprivate'] . '</td>
              <td>
              <a class="edit" href="virtualoffering-edit.php?id='.$row['virtual_offering_id'].'" title="Edit row"><img src="..\assets\img\icons\edit.svg"></a>
              <a class="delete" href="'.$_SERVER['PHP_SELF'].'?id='.$row['virtual_offering_id'].'" title="Delete row"><img src="..\assets\img\icons\delete.svg"></a>
              
              
              
              <div>
                  <form action="" method="POST">
                    <input type="hidden" name="id" value='.$row['virtual_offering_id'].'>';

                    if($row['offering_isconfirmed']) {
                      echo '<input class="btn btn-outline-danger d-block mt-2 btn-sm" name="isConfirmed?" type="Submit" value="Unconfirm">';
                    } else {
                      echo '<input class="btn btn-outline-success d-block mt-2 btn-sm" name="isConfirmed?" type="Submit" value="Confirm">';
                    }
                  echo '</form>';
              
              echo '</div>
              <div class="mt-2"><a class="btn btn-outline-primary btn-sm" href="'.'virtual-enrollment.php'.'?VoID='.$row['virtual_offering_id'].'">See enrollments</a></div></td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
        <button type="button" style="float:right;" class="btn fs-5 py-1 add-row" data-bs-toggle="modal" data-bs-target="#addOffering">+ Add Row</button>
      </div>
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
                  while($row2 = mysqli_fetch_assoc($resultForCourse)) {
                    echo '<option value="'.$row2['course_id'].'">'.$row2['course_name'].'</option>';
                  }?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Trainer Name</label>
              <select class="form-select" name="trainerID">
                <option selected disabled>Trainer Name</option>
                <?php
                  while ($row3 = mysqli_fetch_assoc($resultForTrainer)) {
                    echo '<option value="' . $row3['staff_id'] . '">' . $row3['staff_firstname'].' '.$row3['staff_lastname'] . '</option>';
                  } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Offering Price</label>
              <input type="text" class="form-control" id="price" name="price" placeholder="Price" />
            </div>
            <div class="mb-3">
              <label class="form-label">Videos Link</label>
              <input type="text" class="form-control" id="vidLink" name="vidLink" placeholder="Videos Link" />
            </div>
            <div class="mb-3">
            <label class="form-label">Is it a Private Training</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot1" value="1">
              <label class="form-check-label" for="priOrNot1">
                Yes
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot2" value="0">
              <label class="form-check-label" for="priOrNot2">
                No
              </label>
            </div>
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