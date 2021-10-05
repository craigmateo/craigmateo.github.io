<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM domain";
$result = mysqli_query($connect, $sql);
$sqlforStaff = "SELECT * FROM staff NATURAL JOIN staff_has_role NATURAL JOIN role WHERE role_name = 'Domain Owner';";
$resultforStaff = mysqli_query($connect, $sqlforStaff);

// PHP for delete Domain
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $name=$_POST['name'];
  $sql_delete = "DELETE FROM domain WHERE domain_id='$id';";
  $result_delete = mysqli_query($connect, $sql_delete);
  if($result_delete) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Domain '$name' has been deleted";
    $_SESSION['msg_type'] = "danger";
    exit();    
  } 
  else {
    echo 'Failed to delete' . mysqli_error($connect);
  }
}


// PHP for edit Domain
if (isset($_POST['update'])) {
  //escaping string for safety
  $id=$_POST['id'];
  $domainName=$_POST['domainName'];
  $domainDes=$_POST['domainDesc'];
  $comment=$_POST['domainComm'];

 $sql_update = "UPDATE domain SET  domain_description='$domainDes', domain_comment='$comment', domain_name='$domainName' WHERE domain_id=$id";
  $result_update = mysqli_query($connect, $sql_update);
  if($result_update) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Domain updated successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
  }    
  else {
    echo 'Failed to update' . mysqli_error($connect);
  }
}


// PHP for add Domain
if(isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    if($key != "staff") {
      $copy[$key] = mysqli_real_escape_string ($connect, $value);
    }    
  }

  if(mysqli_query($connect, 'INSERT INTO domain(`domain_name`,`domain_description`, `domain_comment`) VALUES ("'.$copy['domainName'].'","'.$copy['domainDesc'].'","'.$copy['domainComm'].'")')) {
    $insertInSOD = 'INSERT INTO staff_owns_domain VALUES ';
    $valuesToAdd = array(); 
    $id = mysqli_query($connect, "SELECT MAX(domain_id) FROM domain");
    $id = mysqli_fetch_array($id)[0];
    foreach($_POST["staff"] as $staff) {
      $valuesToAdd[] = "('".$staff."','".$id."')";
    }
    // preparing sql for staff_teaches_domain    
    $insertInSOD .= implode(", ", $valuesToAdd);
    if(mysqli_query($connect, $insertInSOD)) {
      mysqli_close($connect);
      header('Location: '.$_SERVER['PHP_SELF']);
      $_SESSION['status'] = "Domain added successfully";
      $_SESSION['msg_type'] = "success";
      exit();  
      echo "<meta http-equiv='refresh' content='0'>"; // form refresh code   
    }
     
  } else {
    echo 'Failed to add '. mysqli_error($connect);
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
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-columns"></i> Domains</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Domain Name</th>
              <th scope="col">Domain Owner</th>
              <th scope="col">Domain Description</th>
              <th scope="col">Domain Comment</th>
              <th scope="col"></th>
              <th scope="col" width="200px"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              $sqlForSOD = 'SELECT * FROM staff NATURAL JOIN staff_owns_domain WHERE domain_id = '.$row['domain_id'];
              $staff = array();
              $resultForSOD = mysqli_query($connect, $sqlForSOD);
              while($row2 = mysqli_fetch_assoc($resultForSOD)) {
                $staff[] = $row2['staff_firstname'].' '.$row2['staff_lastname'];
              }

              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row['domain_name'] . '</td>
              <td>' . implode(", ", $staff) . '</td>
              <td>' . $row['domain_description'] . '</td>
              <td>' . $row['domain_comment'] . '</td>
              <td>
              <td>
                <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-description="' . $row['domain_description'] . '" data-comment="' . $row['domain_comment'] . '" data-name="' . $row['domain_name'] . '" data-id="' . $row['domain_id'] . '"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['domain_id'] . '" del-name="' . $row['domain_name'] . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              </td>
              </td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
        <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Domain</button>
      </div>
    </div>
    <div>
      
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addDomain" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDomainheader">Add Domain</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="mainForm" action="" method="POST">
          <input type="hidden" name="id" id="domain_id" value="">
            <div class="mb-3">
              <label class="form-label">Domain Name</label>
              <input type="text" class="form-control" id="domainName" name="domainName" placeholder="Domain Name" />
            </div>
            <div class="mb-3">
            <label class="form-label">Domain Owner</label>
            <?php
            while ($row2 = mysqli_fetch_assoc($resultforStaff)) {
              echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $row2["staff_id"] . '" name="staff[]" id="' . $row2["staff_id"] . '">
                        <label class="form-check-label" for="' . $row2["staff_id"] . '">'
                        . $row2['staff_firstname'].' '.$row2['staff_lastname'] .
                '</label>
                      </div>';
            }
            ?>
          </div>
            <div class="mb-3">
              <label class="form-label">Domain Description</label>
              <textarea id="domainDesc" name="domainDesc" placeholder="Description..." class="form-control" rows="5" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Domain Comments</label>
              <input type="text" class="form-control" id="domainComm" name="domainComm" placeholder="Domain Comments" />
            </div>
            <input id="submit" class="btn btn-gold text-light d-block ms-auto" name="submit" type="submit" value="Submit">
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
      <input type="hidden" name="id" id="domain_del_id" value="">
      <input type="hidden" name="name" id="domain_name" value="">
			<div class="modal-body">
				<p>Do you really want to delete the record "<span id="domain_del_name"></span>"? This process cannot be undone.</p>
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
  var description = $(this).attr('data-description');
  var comment = $(this).attr('data-comment');
  var name = $(this).attr('data-name');
  var id = $(this).attr('data-id');
// set values on form
  $('#domainDesc').html(description);
  $('#domain_id').val(id);
  $('#domainName').val(name);
  $('#domainComm').val(comment);
// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update Domain");
// change form header
  $("#addDomainheader").html("Edit Domain");
// open form
  $('#addDomain').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addDomainheader").html("Add Domain");
// open form
  $('#addDomain').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  var name = $(this).attr('del-name');
  $('#domain_del_id').val(id);
  $('#domain_name').val(name);
  $('#domain_name').html(name);
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