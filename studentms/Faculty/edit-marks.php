<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid']==0)) {
  header('location:logout-f.php');
  } else{
   if(isset($_POST['submit']))
  {
$attendance=$_POST['attendance'];
 $marks=$_POST['marks'];
 $stuID=$_GET['editid'];
 $course=$_GET['editcourse'];

$sql="update info set marks=:marks,attendance=:attendance where info.studentID=:stuID and info.courseName=:course";
$query=$dbh->prepare($sql);
$query->bindParam(':marks',$marks,PDO::PARAM_INT);
$query->bindParam(':attendance',$attendance,PDO::PARAM_INT);
$query->bindParam(':stuID', $stuID, PDO::PARAM_STR); 
$query->bindParam(':course', $course, PDO::PARAM_STR);
 $query->execute();
$ans=$_GET['id'];
  echo '<script>alert("Marks/Attendence has been updated")</script>';
  echo "<script>window.location.href ='view-student-detail.php?editid=$ans'</script>";
}

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Update Marks/Attendence</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Update Marks/Attendance </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard-f.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Update Marks/Attendance</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update Marks/Attendance</h4>
                   
                    <form class="forms-sample" method="post">
                      <?php
$stuID=$_GET['editid'];
$course=$_GET['editcourse'];
$name=$_GET['name'];
$sql="SELECT * from  info where info.studentID=:stuID and info.courseName=:course ";

$query = $dbh -> prepare($sql);
$query->bindParam(':stuID', $stuID, PDO::PARAM_STR); 
$query->bindParam(':course', $course, PDO::PARAM_STR); 

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>  
                    
                      <div class="form-group">
                        <label for="exampleInputName1">Student Name</label>
                        <input type="text" name="cname" value="<?php  echo htmlentities($name);?>" class="form-control" readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Marks</label>
                        <input type="number" name="marks" value="<?php  echo htmlentities($row->marks);?>" class="form-control" required='true' min=0 max=100>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Attendance</label>
                        <input type="number" name="attendance" value="<?php  echo htmlentities($row->attendance);?>" class="form-control" min=0 max=100 required='true'>
                      </div>

                      <?php $cnt=$cnt+1;}} ?>
                      <button type="submit"  class="btn btn-primary mr-2" name="submit">Update</button>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>