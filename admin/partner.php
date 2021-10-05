<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM partner";
$result = mysqli_query($connect, $sql);

// PHP for delete Partner
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $name=$_POST['name'];
  $sql_delete = "DELETE FROM partner WHERE partner_id='$id';";
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


// PHP for edit Parnter
if (isset($_POST['update'])) {
  //escaping string for safety
  $id=$_POST['id'];
  $partnerName=$_POST['partnerName'];
  $partnerPhone=$_POST['partnerPhone'];
  $partnerEmail=$_POST['partnerEmail'];
  $partnerReprName=$_POST['partnerReprName'];

 $sql_update = "UPDATE partner SET partner_email='$partnerEmail', partner_representative_name='$partnerReprName', partner_phone='$partnerPhone', partner_name='$partnerName' WHERE partner_id=$id";
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

if(isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }
  if(mysqli_query($connect, 'INSERT INTO partner(`partner_name`, `partner_email`, `partner_phone`, `partner_representative_name`) VALUES ("'.$copy['partnerName'].'","'.$copy['partnerEmail'].'","'.$copy['partnerPhone'].'","'.$copy['partnerReprName'].'")')) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
    header('Location: '.$_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Domain added successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
    echo "<meta http-equiv='refresh' content='0'>"; // form refresh code
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

      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-users"></i> Partners</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>         
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone</th>
              <th scope="col">Representative</th>
              <th scope="col" width="200px"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row['partner_name'] . '</td> 
              <td>' . $row['partner_email'] . '</td> 
              <td>' . $row['partner_phone'] . '</td> 
              <td>' . $row['partner_representative_name'] . '</td> 
              <td>
              <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-name="' . $row['partner_name'] . '" data-email="' . $row['partner_email'] . '" data-phone="' . $row['partner_phone']  . '" data-rep="' . $row['partner_representative_name'] . '" data-id="' . $row['partner_id'] . '"><i class="fa fa-edit"></i> Edit</button>
              <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['partner_id'] . '" del-name="' . $row['partner_name'] . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              </td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
        <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Partner</button>
      </div>
    </div>
    <div>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addPartner" tabindex="-1">
    <div class="modal-dialog modal-lg modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPartnerHeader">Add Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="mainForm" action="" method="POST">
          <input type="hidden" name="id" id="partner_id" value="">
            <div class="mb-3">
              <label class="form-label">Partner Name</label>
              <input type="text" class="form-control" id="partnerName" name="partnerName" placeholder="Partner Name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Partner Phone</label>
              <input type="text" class="form-control" id="partnerPhone" name="partnerPhone" placeholder="Partner Phone[+1234567890]" pattern="[\+]{0,1}[0-9]+"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Partner Email</label>
              <input type="email" class="form-control" id="partnerEmail" name="partnerEmail" placeholder="Partner Email" />
            </div>
            <div class="mb-3">
              <label class="form-label">Partner Representative Name</label>
              <input type="text" class="form-control" id="partnerReprName" name="partnerReprName" placeholder="Partner Representative Name" />
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
      <input type="hidden" name="id" id="partner_del_id" value="">
      <input type="hidden" name="name" id="partner_name" value="">
			<div class="modal-body">
				<p>Do you really want to delete the record "<span id="partner_del_name"></span>"? This process cannot be undone.</p>
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
  var phone = $(this).attr('data-phone');
  var email = $(this).attr('data-email');
  var name = $(this).attr('data-name');
  var id = $(this).attr('data-id');
  var rep = $(this).attr('data-rep');
// set values on form
  $('#partnerName').val(name);
  $('#partnerPhone').val(phone);
  $('#partnerEmail').val(email);
  $('#partnerReprName').val(rep);
  $('#partner_id').val(id);
// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update Partner");
// change form header
  $("#addPartnerHeader").html("Edit Parner");
// open form
  $('#addPartner').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addPartnerHeader").html("Add Partner");
// open form
  $('#addPartner').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  var name = $(this).attr('del-name');
  $('#partner_del_id').val(id);
  $('#partner_name').val(name);
  $('#partner_del_name').html(name);
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