<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header('location: login.php');
  }
  $page = 'training';
  include('_adminincludes/header.php');
?>

<div class="col-sm-9 col-md-10 mt-3">
<div class="massage-bar mb-1">
<div class="alert alert-warning alert-dismissible fade show" role="alert" id="admin-alert">
  <strong><i class="fa fa-code" style="font-size:24px;"></i> Under construction</strong> <br><br>The admin code is in progress. You are welcome to start using it, but not all functionality is ready and there may be errors. 
  <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" onclick="$('#admin-alert').hide();">
  </button>
</div>
</div>
</div>




<?php
  include('_adminincludes/footer.php')
?>