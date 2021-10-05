<?php
include('_adminincludes/db_connection.php');
if (isset($_POST['submit'])) {
  $username = $_POST["user"];
  $password = $_POST["pass"];

  // Get hashedpw
  $pwsql = "SELECT staff_username, staff_hashedpassword, staff_id FROM staff WHERE staff_username ='".$username."'";
  $pwresult = mysqli_query($connect, $pwsql);
  if (mysqli_num_rows($pwresult) == 0) { // returned nothing
    echo "username or password incorrect";
  } else {
    $row = $pwresult->fetch_assoc();
    $hash = $row['staff_hashedpassword'];
    if (password_verify($password,$hash)) { // verify password
      session_start();
      $roles = array();
      $sqlForPHR = "SELECT role_id FROM staff_has_role WHERE staff_id = ".$row['staff_id'];
      $resultForPHR = mysqli_query($connect, $sqlForPHR);
      while($row1 = mysqli_fetch_assoc($resultForPHR)) {
        $sqlForRoles = "SELECT * FROM role WHERE role_id = ".$row1['role_id'];
        $resultForRoles = mysqli_query($connect, $sqlForRoles);
        while($row2 = mysqli_fetch_assoc($resultForRoles)) {
          $roles[] = $row2; 
        }     
      }
      $_SESSION['roles'] = $roles;
      $_SESSION['username'] = $row['staff_username'];
      //print_r($_SESSION['roles']);
      header('location: admin.php');
    } else {
      echo "username or password incorrect";
    }
  }

  // if ($username == 'test' && $password == 'test') {
  //   session_start();
  //   $_SESSION['username'] = $username;
  //   header('location: admin.php');
  // } else {
  //   echo "username or password incorrect";
  // }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>LOGIN</title>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="..\assets\css\loginstyle.css">
</head>

<body onload="translateiso2ToNames()">

  <div class="container mt-8 shadow px-0">
  <img src="..\assets\img\logo\q7_logo_sq.png"/>
    <div class="d-flex justify-content-center">
      <div class="w-50 p-4">
        <div>
          <form action="#" method="POST">
            <div class="mb-3 form-input">
              <input type="text" class="form-control" id="user" name="user" autocomplete="off" placeholder="Enter your username"/>
            </div>
            <div class="mb-3 form-input">
              <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter your password"/>
            </div>
            <input type="submit" name="submit" value="Login" class="btn-login">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>