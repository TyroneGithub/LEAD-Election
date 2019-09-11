<?php
include 'connection.php';
session_start();
if (empty($_SESSION['username'])){
    header('location:index.php'); 
}
else if ($_SESSION['type']=='student'){
    header('location:main.php?type=student');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/admin/student.css">
    <script src="js/overlay.js"></script>
    <link rel="stylesheet" href="css/admin/edit-overlay.css">
    <script src="js/status-overlay.js"></script>
  
    <title>Students</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>

    <script>
    $(document).ready( function () {
    $('#table_id').DataTable();
    } );
    </script>







</head>
<body>

    <?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>

<div class='main-wrap'>
<div class='box'>

<?php 
    if (isset($_GET['add']) or isset($_GET['remove']) ){
?>
    <body onload="editSuccess_on();">

    </body>
  <?php  }
    ?>
    <div id='status-overlay'><div id='status-box'>
        <h2>
        <img src='images/green-check.png'/>
        <br>
        <?php
         if (isset($_GET['add'])){
             echo "Added Successfully!";
         }
         else if (isset($_GET['remove'])){
             echo "All Students Removed!";
         }
        ?>       
        </h2>
        <button onclick='edit_off();'>Close</button>
        </div></div>


<h2>Students</h2>
<div class='add'>
<h3>List of Sections</h3>

<?php
  $get_date = "SELECT * FROM schedule WHERE sched_id=1";
  $result_date = mysqli_query($connection,$get_date);
  $count_date = mysqli_num_rows($result_date);
  while ($row_date = mysqli_fetch_assoc($result_date)){
      $start_date = $row_date['start_date'];
      $end_date = $row_date['end_date'];
      $election = $row_date['election'];
      $drafting = $row_date['drafting'];
  }
  $curr_date = date('Y-m-d');
 

?>
<a onclick='addStudent();'><h4 ><i class='fas fa-plus-circle'></i> Add Student</h4></a>
<h4 style='margin-left:15px; width:70px;' onclick='importcsv_on();'><i class='fas fa-upload'></i>Import</h4>

<?php
  if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
?>
<a href='remove-all.php' onclick="return confirm('Are you sure you want to remove all students?')">
<h4 style='width:170px; color:#c23b22; margin-left:15px;'>
<i class='fas fa-user-slash'></i>Remove all students </h4></a>
<?php
  }
  else{
?>
<a nohref='remove-all.php' >
<h4 style='width:170px; color:#c23b22; margin-left:15px; cursor:not-allowed;'>
<i class='fas fa-user-slash'></i>Remove all students </h4></a>
<?php
  }
?>


</div>








<!-- Import csv form !-->
<div class='form' id='csv-form' style="display:none; height:275px;">
<div class='form-header'><h2>Import Student List</h2></div>
<form action="importcsv.php" method = "POST" enctype="multipart/form-data">
    <input type = "file" name = "file"/>
    <input type = "submit" name ="importSubmit" value="Import"/>
</form>
<button class='cancel' onclick='importcsv_off();'>Cancel</button>
<br>
<a href="http://www.tyronesm.co.nf/?t=61305" target="_blank" 
style="margin-left:25px; color:#3f72b8;">See sample format here </a>
</div>

<!-- END !--> 


<!-- List of Students Start!-->
<div id ='table-hide'>
<table id="table_id" >
    <thead>    
        <tr>
        <th class='sec'>Section</th>
        <th class='stud-num'>Students</th>     
        </tr>
    </thead>
    <tbody>
        <?php
        $get_section = "SELECT * FROM section WHERE active =1
        ORDER BY level ASC";
        $res_section = mysqli_query($connection,$get_section);
        while($row_section=mysqli_fetch_assoc($res_section)){
            $sec_id = $row_section['section_id'];
            $section = $row_section['section_name'];
            $level = $row_section['level'];
        $get_student_count = "SELECT * FROM users INNER JOIN section
        ON users.section = section.section_id WHERE section = '$sec_id'
        AND users.active=1 AND section.active=1";
        $res_student_count = mysqli_query($connection,$get_student_count);
        $count = mysqli_num_rows($res_student_count);
        $get_vote_count = "SELECT * FROM users INNER JOIN response 
        ON users.username = response.voter_id WHERE section= '$sec_id'
        AND users.active=1 ";
        $res_vote_count = mysqli_query($connection,$get_vote_count);
        $count_voter = mysqli_num_rows($res_vote_count);
            echo "
            <tr>
            <td>
            <a href='student-list.php?sec_id=$sec_id'>
            $level-$section
            </a>
            </td>
            <td>
           $count_voter/$count
            </td>
            </tr>
            
            ";
        }
        
        ?>

        </tbody>
        </table>

    </div>
<!-- List of Students End!-->



<!-- Add Student Start!-->
<div class='form' id='form-hide'>
<div class='form-header'><h2>Add Student</h2></div>
<form action="add_student.php" method="post" autocomplete='off'>
<label for = 'student-no'>Student Number:</label>
<input type="text" name="username" id="student-no" required/>
<br>
<br>
<label for = 'name'>Name:</label>
<input type="text" name="name" id="name" required/>
<br>
<br>
<label for = 'section'>Section:</label>
<select name="section" id="section" required >
<option value="">Select Section</option>
<?php
    $get_section = "SELECT * FROM section WHERE active =1 ";
    $res_section = mysqli_query($connection,$get_section);
    while($row_section=mysqli_fetch_assoc($res_section)){
        $sec_id = $row_section['section_id'];
        $section = $row_section['section_name'];
        $level = $row_section['level'];
        echo "<option value='$sec_id' >$level-$section</option>";
    }

?>
</select>
<br>
<br>
<label for = 'password'>Password:</label>
<input type="password" name="password" id="password" required/>
<input type="submit" value="Submit" name = 'submit-form'>
<button class='cancel' onclick='addStudent_off();'>Cancel</button>

</form>
</div>
<!-- Add Student End!-->
</div>
</div>
<div id="overlay" style="display:none;"></div>
</body>
</html>