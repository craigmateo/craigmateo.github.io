<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');

$sql = "SELECT * FROM course";
$result = mysqli_query($connect, $sql);
$sqlForCategory = "SELECT * FROM category";
$resultForCategory = mysqli_query($connect, $sqlForCategory);
$sqlForLang = "SELECT * FROM language";
$resultForLang = mysqli_query($connect, $sqlForLang);

// PHP for delete Course Type
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $name=$_POST['name'];
  $sql_delete = "DELETE FROM course WHERE course_id='$id';";
  $result_delete = mysqli_query($connect, $sql_delete);
  if($result_delete) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Course Type '$name' has been deleted";
    $_SESSION['msg_type'] = "danger";
    exit();    
  } 
  else {
    echo 'Failed to delete' . mysqli_error($connect);
  }
}


// PHP for edit Course Type
if (isset($_POST['update'])) {
  //escaping string for safety
  $id=$_POST['id'];
  $courseName=$_POST['courseName'];
  $courseDes=$_POST['courseDesc'];
  $comment=$_POST['courseComm'];
  $difficulty=$_POST['courseDiff'];
  $category=$_POST['catID'];
  $language=$_POST['langID'];
  $syllabus=$_POST['courseSyll'];
  $exam=$_POST['hasExam'];


 $sql_update = "UPDATE course SET course_description='$courseDes', course_language='$language', course_name='$courseName', course_comment='$comment', course_hasexam='$exam', course_difficulty='$difficulty', category_id='$category', course_syllabus='$syllabus' WHERE course_id=$id";
  $result_update = mysqli_query($connect, $sql_update);
  if($result_update) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Course Type updated successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
  }    
  else {
    echo 'Failed to update' . mysqli_error($connect);
  }
}

if (isset($_POST['submit'])) {
  //escaping string for safety
  $prereq;
  $copy = array();
  
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }
  /* removed prereq */ 
  /* echo '<pre>'; print_r($copy); echo '</pre>'; */

  $addSQL = 'INSERT INTO course(`category_id`, `course_language`, `course_name`, `course_syllabus`, `course_description`, `course_comment`, `course_createdat`, `course_difficulty`, `course_hasexam`) VALUES ("' . $copy['catID'] . '","' . $copy['langID'] . '","' . $copy['courseName'] . '","' . $copy['courseSyll'] . '","' . $copy['courseDesc'] . '","' . $copy['courseComm'] . '",CURRENT_DATE(),"' . $copy['courseDiff'] . '","'  . $copy['hasExam'] . '")';
  if (mysqli_query($connect, $addSQL)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Course Type added successfully";
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
      <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-file"></i> Course-Types</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Course Name</th>
        <th scope="col">Syllabus</th>
        <th scope="col">Description</th>
        <th scope="col">Prerequisite</th>
        <th scope="col">Difficulty</th>
        <th scope="col">Exam</th>
        <th scope="col" width="200px"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $index = 1; 
        while ($row = mysqli_fetch_assoc($result)) {
        $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sql. ' WHERE course_id = '. $row['course_prerequisite']));
        $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCategory . ' where category_id = ' . $row['category_id']));
        $b = '';
        if ($row['course_hasexam'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }


        $languageJSON = json_decode(file_get_contents('languages.json'), TRUE);
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row['course_name'] . '</td>
              <td><a target="_blank" type="button" class="btn link-button" href="' . $row['course_syllabus'] . '"' . 'title="' . $row['course_syllabus'] . '">Link&nbsp;</a></td>  
              <td>' . $row['course_description'] . '</td>
              <td>' . $row3['course_name'] . '</td>
              <td>' . $row['course_difficulty'] . '</td>
              <td>' . $b . '</td>
              <td>
              
              <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-syllabus="' . $row['course_syllabus'] . '" data-comment="' . $row['course_comment'] . '" data-createdat="' . $row['course_createdat'] . '" data-language="' . $languageJSON[$row['course_language']]['name'] . '" data-category="' . $row['category_id'] . '" data-difficulty="' . $row['course_difficulty'] . '" data-prerequisite="' . $row['course_prerequisite'] . '" data-description="' . $row['course_description'] . '" data-name="' . $row['course_name'] . '" data-exam="' . $b . '" data-id="' . $row['course_id'] . '"><i class="fa fa-edit"></i> Edit</button>
              <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['course_id'] . '" del-name="' . $row3['course_name'] . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              <button type="button" class="btn btn-link expand-row btn-sm" data-bs-toggle="collapse" href="#course-type'. $index . '" role="button" id="text_mode" title="Expand Row"><i class="fa fa-expand"></i></button>
              </tr>
              <tr> 
                <td colspan="11" class="border-0 p-0">
                  <div class="collapse" id="course-type'.$index.'">
                    <div class="card card-body">
                      <p><strong>Category: </strong>'. $row2['category_name'] .'</p>
                      <p><strong>Comments: </strong>' . $row['course_comment'] .'</p>
                      <p><strong>Language: </strong>'. $languageJSON[$row['course_language']]['name'] .'</p>
                      <p><strong>Creation Date: </strong>' . $row['course_createdat'] .'</p>
                    </div>
                  </div>
                </td>
              </tr>';
        $index++;
      } ?>
    </tbody>
  </table>
  <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Course Type</button>
</div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="addCourse" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCourseheader">Add Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="mainForm">
        <input type="hidden" name="id" id="course_id" value="">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <select class="form-select" name="catID" id="catID" required>
            <option id="categorySelected" value=""></option>
              <?php
              if(mysqli_num_rows($resultForCategory) > 0) {
                echo '<option value="" selected disabled>Category Name</option>';
                while ($row2 = mysqli_fetch_assoc($resultForCategory)) {
                  echo '<option value="' . $row2['category_id'] . '">' . $row2['category_name'] . '</option>';
                }
              } else {
                echo '<option value="" selected disabled>Please Add Some Categories First</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Language Name</label>
            <select class="form-select" name="langID" id="langID" required>
              <option value="" disabled selected>Choose a Language</option>
              <option id="languageSelected" value=""></option>
              <?php 
                $languageJSON = json_decode(file_get_contents('languages.json'), TRUE);
                foreach($languageJSON as $key => $value) {
                  echo '<option value="'.$key.'">'.$value['name'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" name="courseName" placeholder="Course Name" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Syllabus Link (i.e. OneDrive link)</label>
            <input type="text" class="form-control" id="courseSyll" name="courseSyll" placeholder="Course Syllabus" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Description</label>
            <textarea name="courseDesc" id="courseDesc" placeholder="Description..." class="form-control" rows="5" style="resize: none;"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Course Comments</label>
            <input type="text" class="form-control" id="courseComm" name="courseComm" placeholder="Course Comments" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Difficulty</label>
            <input type="text" class="form-control" id="courseDiff" name="courseDiff" placeholder="Course Difficulty" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Prerequisite <em style="color:red">field in progress</em></label>
            <select class="form-select" name="coursePreReq" id="coursePreReq">
              <option value="" disabled selected>Choose a Prerequisite</option>
              <option id="prereqSelected" value=""></option>
              <?php
                $result = mysqli_query($connect, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                  
                  echo '<option value="'.$row['course_id'].'">'.$row['course_name'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="mb-3">
          <label class="form-label">Does the course have a exam?</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hasExam" id="hasExam1" value="1" required>
                <label class="form-check-label" for="hasExam1">
                  Yes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hasExam" id="hasExam2" value="0" required>
                <label class="form-check-label" for="hasExam2">
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
      <input type="hidden" name="id" id="course_del_id" value="">
      <input type="hidden" name="name" id="course_name" value="">
			<div class="modal-body">
				<p>Do you really want to delete the record "<span id="course_del_name"></span>"? This process cannot be undone.</p>
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
  var syllabus = $(this).attr('data-syllabus');
  var name = $(this).attr('data-name');
  var difficulty = $(this).attr('data-difficulty');
  var id = $(this).attr('data-id');
  var exam = $(this).attr('data-exam');
  var prereq = $(this).attr('data-prerequisite');
  var category = $(this).attr('data-category');

  var comment = $(this).attr('data-comment');
  var createdat = $(this).attr('data-createdat');
  var language = $(this).attr('data-language');

// set values on form
  $('#courseDesc').html(description);
  $('#course_id').val(id);
  $('#courseSyll').val(syllabus);
  $('#coursePreReq').val(prereq);
  $('#courseName').val(name);
  $('#courseDiff').val(difficulty);
  $('#courseComm').val(comment);

  $( "#categorySelected" ).show();
  $( "#languageSelected" ).show();
  $( "#prereqSelected" ).show();

  $('#catID').val(category);


  $('#languageSelected').val(language);
  $('#languageSelected').html(language);
  document.getElementById("langID").selectedIndex = "1";

  $('#prereqSelected').val(prereq);
  $('#prereqSelected').html(prereq);
  document.getElementById("coursePreReq").selectedIndex = "1";

  if (exam=="Yes") {
    $("#hasExam1").prop("checked", true);
  }
  else {
    $("#hasExam2").prop("checked", true);
  }
// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update Course Type");
// change form header
  $("#addCourseheader").html("Edit Course Type");
// open form
  $('#addCourse').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
  $( "#categorySelected" ).hide();
  $( "#languageSelected" ).hide();
  $( "#prereqSelected" ).hide();

// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addCourseheader").html("Add Domain");
// open form
  $('#addCourse').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  var name = $(this).attr('del-name');
  $('#course_del_id').val(id);
  $('#course_name').val(name);
  $('#course_name').html(name);
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