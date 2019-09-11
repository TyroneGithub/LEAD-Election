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
    <link rel="stylesheet" href="css/admin/student-list.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>

  <script>
  $(document).ready( function () {
  $('#table_id').DataTable();
  } );

  </script>

<script src="loader.js"></script>
<script>
window.onload = function setNavLight(){
  homepage_off();
  //icon_mypanel.setAttribute("class","activeLink");
}
</script>




    <title><?php
    $sec_id = $_GET['sec_id'];
    $get_section = "SELECT * FROM section WHERE active =1 AND section_id =$sec_id ";
    $res_sec = mysqli_query($connection,$get_section);
    while($row_sec=mysqli_fetch_assoc($res_sec)){
        $sec_name = $row_sec['section_name'];
        $level = $row_sec['level'];
        echo $sec_name;
    }
    ?></title>
</head>
<body onload="overlay_off();">
    
<?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>
<div class='main-wrap'>
<div class='box'>
<h2> <a href="students.php" class='back'><i class="fas fa-arrow-left"></i></a>  
 <?php echo "$level-$sec_name"; ?></h2>

<!-- List of Students Start!-->
<div id ='table-hide'>
<table id="table_id" >
    <thead>    
        <tr>
        <th class='sec'>Status</th> 
        <th>Student </th>
        <th class='stud-num'>Options</th>  
          
        </tr>
    </thead>
    <tbody>
        <?php
          $get_date = "SELECT * FROM schedule WHERE  sched_id=1";
          $result_date = mysqli_query($connection,$get_date);
          $count_date = mysqli_num_rows($result_date);
          while ($row_date = mysqli_fetch_assoc($result_date)){
              $start_date = $row_date['start_date'];
              $end_date = $row_date['end_date'];
              $election = $row_date['election'];
              $drafting = $row_date['drafting'];
          }
          $curr_date = date('Y-m-d');
        $get_student = "SELECT * FROM users WHERE active =1 AND section =$sec_id ";
        $res_student = mysqli_query($connection,$get_student);
        while($row_student=mysqli_fetch_assoc($res_student)){
            $user_id = $row_student['user_id'];
            $name = $row_student['name'];
            $username = $row_student['username'];
        $get_voted = "SELECT * FROM users INNER JOIN response 
        ON users.username = response.voter_id
        WHERE voter_id = '$username' AND users.active=1  ";
        $res_voted = mysqli_query($connection,$get_voted);
        $count_voted = mysqli_num_rows($res_voted);
        // if election period is set 
      
            // if election period has not started
        if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
            if ($count_voted==0){
                // not voted
                echo "
                <tr>
                <td>---</td>
                <td>
                $name
                </td>
                <td>
                <a href='edit-student.php?edit=$user_id&type=student'><i class='far fa-edit'></i>
                 Edit</a>
                <a href='remove-student.php?remove=$user_id&type=student' class='remove' ";
            ?>
                  onclick="return confirm('Are you sure you want to remove this student? Changes cannot be undone.');">
                <i class='fas fa-user-slash'></i>
                Remove</a>
                </td>
                </tr>
           
            <?php
            }
            // voted
             else{
                echo "
                <tr>
                <td><i class='fas fa-check-circle' style='color:green;'></i></td>
                <td>
                $name
                </td>
                <td>
                <a href='edit-student.php?edit=$user_id&type=student'><i class='far fa-edit'></i>
                 Edit</a>
                <a href='remove-student.php?remove=$user_id&type=student' class='remove' ";
            ?>
              onclick="return confirm('Are you sure you want to remove this student? Changes cannot be undone.');">
                <i class='fas fa-user-slash'></i>
                Remove</a>
                </td>
                </tr>
            <?php
            }
        }
        // if election period has started
        else{
            if ($count_voted==0){
                // not voted
                echo "
                <tr>
                <td>---</td>
                <td>
                $name
                </td>
                <td>
                <a nohref='edit-student.php?edit=$user_id&type=student'><i class='far fa-edit'></i>
                 Edit</a>
                <a nohref='remove-student.php?remove=$user_id&type=student' class='remove'>
                <i class='fas fa-user-slash'></i>
                Remove</a>
                </td>
                </tr>
                ";
                ?>
            <?php
            }
            // voted
             else{
                echo "
                <tr>
                <td><i class='fas fa-check-circle' style='color:green;'></i></td>
                <td>
                $name
                </td>
                <td>
                <a nohref='edit-student.php?edit=$user_id&type=student'><i class='far fa-edit'></i>
                 Edit</a>
                <a nohref='remove-student.php?remove=$user_id&type=student' class='remove'>
                <i class='fas fa-user-slash'></i>
                Remove</a>
                </td>
                </tr>";
            ?>
      <?php  }
        }
            ?>
        <?php
        
    }
        ?>

        </tbody>
        </table>

    </div>


</body>
</html>