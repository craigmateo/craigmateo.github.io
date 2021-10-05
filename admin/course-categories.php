<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM category";
$sqlForDomain = "SELECT * FROM domain";
$resultForDomain = mysqli_query($connect, $sqlForDomain);
$result = mysqli_query($connect, $sql);


// PHP for delete Domain
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $name=$_POST['name'];
  $sql_delete = "DELETE FROM category WHERE category_id='$id';";
  $result_delete = mysqli_query($connect, $sql_delete);
  if($result_delete) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Category '$name' has been deleted";
    $_SESSION['msg_type'] = "danger";
    exit();    
  } 
  else {
    echo 'Failed to delete' . mysqli_error($connect);
  }
}


if(isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }
  if(mysqli_query($connect, 'INSERT INTO category(`domain_id`, `category_name`, `category_description`, `category_comment`) VALUES ("'.$copy['domainID'].'","'.$copy['categoryName'].'","'.$copy['categoryDesc'].'","'.$copy['categoryComm'].'")')) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Domain added successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
    echo "<meta http-equiv='refresh' content='0'>"; // form refresh code
  } 
  
  else {
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
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-sitemap"></i> Course Categories</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Domain Name</th>              
              <th scope="col">Category Name</th>
              <th scope="col">Category Description</th>
              <th scope="col">Category Comment</th>
              <th scope="col" width="200px"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              
              $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForDomain.' where domain_id = '.$row['domain_id'])); 
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['domain_name'] . '</td>
              <td>' . $row['category_name'] . '</td>
              <td>' . $row['category_description'] . '</td>
              <td>' . $row['category_comment'] . '</td>
              <td>
              <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-description="' . $row['category_description'] . '" data-comment="' . $row['category_comment'] . '" data-domname="' . $row2['domain_name'] . '" data-name="' . $row['category_name'] . '" data-id="' . $row['category_id'] . '"><i class="fa fa-edit"></i> Edit</button>
              <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['category_id'] . '" del-name="' . $row['category_name'] . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              </td>
              </tr>';
              $index++;
              
            }

            ?>
          </tbody>
        </table>
        <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Category</button>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addCategory" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryHeader">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="mainForm" action="" method="POST">
          <input type="hidden" name="id" id="category_id" value="">
            <div class="mb-3">
              <label class="form-label">Domain Name</label>
              <select class="form-select" name="domainID" id="domainID">
                <option selected disabled>Domain Name</option>
                <option id="domainSelected" value=""></option>
                <?php 
                  while($row2 = mysqli_fetch_assoc($resultForDomain)) {
                    echo '<option value="'.$row2['domain_id'].'">'.$row2['domain_name'].'</option>';
                  }?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Category Name</label>
              <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Category Desc</label>
              <textarea name="categoryDesc" placeholder="Description..." class="form-control" rows="5" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Category Comments</label>
              <input type="text" class="form-control" id="categoryComm" name="categoryComm" placeholder="Category Comments" />
            </div>
            <input class="btn btn-success d-block ms-auto" name="submit" type="Submit" value="Submit">
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
      <input type="hidden" name="id" id="category_del_id" value="">
      <input type="hidden" name="name" id="category_name" value="">
			<div class="modal-body">
				<p>Do you really want to delete the record "<span id="category_del_name"></span>"? This process cannot be undone.</p>
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
  var domname = $(this).attr('data-domname');
  var id = $(this).attr('data-id');
// set values on form
  $('#categoryDesc').html(description);
  $('#category_id').val(id);
  $('#categoryName').val(name);
  $('#categoryComm').val(comment);
  $( "#domainSelected" ).show();
  $('#domainSelected').val(domname);
  $('#domainSelected').html(domname);
  document.getElementById("domainID").selectedIndex = "1";
// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update category");
// change form header
  $("#addCategoryheader").html("Edit category");
// open form
  $('#addCategory').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
  $( "#domainSelected" ).hide();
  
// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addCategoryheader").html("Add Domain");
// open form
  $('#addCategory').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  var name = $(this).attr('del-name');
  $('#category_del_id').val(id);
  $('#category_name').val(name);
  $('#category_name').html(name);
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