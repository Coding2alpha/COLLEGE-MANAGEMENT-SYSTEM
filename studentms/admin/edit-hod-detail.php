<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
 $eid=$_GET['editid'];
 $faculty=$_POST['faculty'];

$sql="update hod set HOD=:faculty where department=:eid";
$query=$dbh->prepare($sql);
$query->bindParam(':faculty',$faculty,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();
  echo '<script>alert("Faculty has been assigned")</script>';
  echo "<script>window.location.href ='Assign-Hod.php'</script>";
}

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Assign Course</title>
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
              <h3 class="page-title"> Assign Faculty </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Assign Faculty</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Assign Faculty</h4>
                   
                    <form class="forms-sample" method="post">
      <?php                
$eid=$_GET['editid'];
$hod=$_GET['hod'];
?>

                      
                      <div class="form-group">
                        <label for="exampleInputEmail3">Department</label>
                        <select  name="section" class="form-control" readonly='true'>
                          <option value=":eid"><?php  echo $eid;?></option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Assign Faculty</label>
                        <select  name="faculty" class="form-control" required='true'>
                          <option value=""><?php  echo $hod;?></option>
                         <?php 


    $sql2 = "SELECT * FROM tblfaculty WHERE department = :eid";
    $query2 = $dbh->prepare($sql2);
    $query2->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
  

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->FacultyName);?>"><?php echo htmlentities($row1->FacultyName);?></option>
 <?php }?> 
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit" >Update</button>
                     
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