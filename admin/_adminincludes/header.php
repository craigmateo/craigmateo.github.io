<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap 5 -->
  <link rel="stylesheet" href="../assets/custom-scss/main.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="admin.css">
  
  <!-- multiselect css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Admin</title>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid mt-5">
      <a class="navbar-brand" href="index.html" id="logo">
        <img width="220px" id="logo_img" src="../assets/img/logo/q7_logo.png" alt="Company-logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0 container-fluid">
          <li class="nav-item mx-xxl-3">
            <a class="nav-link lang" href="admin.php" key="about">Trainings</a>
          </li>
          <li class="nav-item mx-xxl-3">
            <a class="nav-link lang" href="staff.php" key="training">Users</a>
          </li>
        </ul>
        <div class="ms-lg-auto me-3">
          <a class="text-white fw-bolder" href="profile.php"><?= $_SESSION['username'] ?></a>
          
        </div>
        <a class="btn btn-gold text-light mt-3 mt-lg-0 me-3 " href="_adminincludes/logout.php">Logout</a>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 bg-light pt-3 pb-2">
        <ul class="nav nav-pills flex-column mb-auto">

          <?php if ($page == 'training') {
            echo
            '
          <li class="nav-item">
            <a href="admin.php" class="nav-link side-link link-dark" aria-current="page">
              Home
            </a>
          </li>
          <li>
            <a href="venue.php" class="nav-link link-dark side-link">
              Venues
            </a>
          </li>
          <li>
            <a href="domain.php" class="nav-link link-dark side-link">
              Domains
            </a>
          </li>
          <li>
            <a href="partner.php" class="nav-link link-dark side-link">
              Partners
            </a>
          </li>
          <li>
            <a href="course-categories.php" class="nav-link link-dark side-link">
              Course Categories
            </a>
          </li>
          <li>
            <a href="courses-type.php" class="nav-link link-dark side-link">
              Course-Types
            </a>
          </li>
          <li>
            <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Offerings
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item side-link" href="inperson-offering.php">In Person</a></li>
                <li><a class="dropdown-item side-link" href="online-offering.php">Online</a></li>
                <li><a class="dropdown-item side-link" href="virtual-offering.php">Virtual</a></li>
                <li><a class="dropdown-item side-link" href="partner-offering.php">Partner</a></li>
              </ul>
            </div>
          </li>
          <li>
            <a href="inquiries.php" class="nav-link link-dark side-link">
                Inquiries
            </a>
          </li>';
          } else if ($page == 'users') {
            echo
            '<li>
              <a href="staff.php" class="nav-link link-dark side-link">
                Staff
              </a>
            </li>
            <li>
              <a href="roles.php" class="nav-link link-dark side-link">
                Roles
              </a>
            </li>
            <li>
              <a href="participant.php" class="nav-link link-dark side-link">
                Participants
              </a>
            </li>'; 
          } ?>
        </ul>
      </div>