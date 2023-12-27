<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout-f.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Student Management System||| Students</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- End layout styles -->

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once('includes/header.php'); ?>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Manage Students </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard-f.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Manage Students</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h4 class="card-title mb-sm-0">Manage Students</h4>
                                        <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Students</a>
                                    </div>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">S.No</th>
                                                    <th class="font-weight-bold">Student ID</th>
                                                    <th class="font-weight-bold">Student name</th>
                                                    <th class="font-weight-bold">Marks </th>
                                                    <th class="font-weight-bold">Attendance </th>
                                                    <th class="font-weight-bold">Edit Marks and Attendance</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['pageno'])) {
                                                    $pageno = $_GET['pageno'];
                                                } else {
                                                    $pageno = 1;
                                                }

                                                $no_of_records_per_page = 15;
                                                $offset = ($pageno - 1) * $no_of_records_per_page;
                                                $ret = "SELECT ID FROM tblstudent";
                                                $query1 = $dbh->prepare($ret);
                                                $query1->execute();
                                                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                $total_rows = $query1->rowCount();
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);

                                                $sid = $_GET['editid'];
                                                $fname = "SELECT tblclass.ClassName FROM tblclass WHERE tblclass.ID=:sid";

                                                $query2 = $dbh->prepare($fname);
                                                $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
                                                $query2->execute();
                                                $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($results2 as $r) {
                                                    $name = $r->ClassName;
                                                }

                                                $sql = "SELECT tblstudent.StudentName,tblstudent.StuID,tblstudent.ID 
                                                        FROM tblstudent 
                                                        JOIN info ON tblstudent.ID=info.studentID 
                                                        WHERE info.courseName=:name LIMIT $offset, $no_of_records_per_page";

                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':name', $name, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->StuID); ?></td>
                                                            <td><?php echo htmlentities($row->StudentName); ?></td>

                                                            <?php
                                                            $ans = $row->ID;
                                                            $s = "SELECT info.marks, info.attendance
                                                            from info 
                                                            JOIN tblstudent ON tblstudent.ID = info.studentID
                                                            JOIN tblclass ON tblclass.ClassName = info.courseName 
                                                            WHERE info.courseName=:name && info.studentID=:ans  LIMIT $offset, $no_of_records_per_page";

                                                            $query1 = $dbh->prepare($s);
                                                            $query1->bindParam(':name', $name, PDO::PARAM_STR);
                                                            $query1->bindParam(':ans', $ans, PDO::PARAM_STR);
                                                            $query1->execute();
                                                            $innerResults = $query1->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query1->rowCount() > 0){
                                                            foreach ($innerResults as $r) {
                                                            ?>
                                                                <td><?php echo htmlentities($r->marks); ?></td>
                                                                <td><?php echo htmlentities($r->attendance); ?></td>
                                                            <?php
                                                            }}else{
                                                                ?>
                                                                <td>NA</td>
                                                                <td>NA</td>
                                                            <?php
                                                            }
                                                            ?>

                            
                                                            <td>
                                                            <div>
    <a href="edit-marks.php?editid=<?php echo htmlentities($row->ID); ?>&editcourse=<?php echo htmlentities($name); ?>&id=<?php echo htmlentities($sid); ?>&name=<?php echo htmlentities($row->StudentName); ?>">
        <i class="icon-eye"></i>
    </a>
</div>

                                                            </td>
                                                        </tr>
                                                <?php
                                                        $cnt = $cnt + 1;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div align="left">
                                        <ul class="pagination">
                                            <li><a href="?pageno=1"><strong>First></strong></a></li>
                                            <li class="<?php if ($pageno <= 1) {
                                                            echo 'disabled';
                                                        } ?>">
                                                <a href="<?php if ($pageno <= 1) {
                                                                echo '#';
                                                            } else {
                                                                echo "?pageno=" . ($pageno - 1);
                                                            } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                            </li>
                                            <li class="<?php if ($pageno >= $total_pages) {
                                                            echo 'disabled';
                                                        } ?>">
                                                <a href="<?php if ($pageno >= $total_pages) {
                                                                echo '#';
                                                            } else {
                                                                echo "?pageno=" . ($pageno + 1);
                                                            } ?>"><strong style="padding
