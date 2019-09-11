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
    <link rel="stylesheet" href="css/admin/candidates.css">
    <title>List of Candidates</title>
    <link rel="stylesheet" href="css/admin/edit-overlay.css">
    <script src="js/status-overlay.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
  <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script>

<script>
$(document).ready( function () {
$('#table_id').DataTable();
} );

</script>
<script src="js/overlay.js"></script>
</head>
<body>
    
<?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>

<div class='main-wrap'>
<div class='box'>

<?php 
    if (isset($_GET['add'])){
?>
    <body onload="editSuccess_on();">

    </body>
  <?php  }
    ?>
    <div id='status-overlay'><div id='status-box'>
        <h2>
        <img src='images/green-check.png'/>
        <br>
        
        Added Successfully!
       
        </h2>
        <button onclick='edit_off();'>Close</button>
        </div></div>

<h2>Candidates</h2>
<h3>List of Candidates</h3>
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
  
    if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
        echo "<h4 onclick='addCandidate();'><i class='fas fa-plus-circle'></i> Add Candidate</h4>";
    }
    else{
        echo "<h4 style='cursor:not-allowed'><i class='fas fa-plus-circle'></i> Add Candidate</h4>";
    }

?>

<!--TABLE START !-->
<table id='candidate-table'>
    
        <tr>
        <th class='sec'>Student </th>
        <th class='stud-num'>Options</th>     
        </tr>
   
   
   <?php


$get_pos = "SELECT * FROM position INNER JOIN candidate
ON position.position_id = candidate.position
WHERE position.active =1 AND candidate.active=1 GROUP BY position_id  ";
$res_pos = mysqli_query($connection,$get_pos);
while ($row_pos = mysqli_fetch_assoc($res_pos)){
    $pos_no = $row_pos['position_id'];
    $pos_name = $row_pos['pos_name'];
    echo "<tr>
    <th class='position'>$pos_name</th>
    <th class='position'></th>
    </tr>";
$get_cand = "SELECT * FROM candidate INNER JOIN position 
ON candidate.position = position.position_id 
INNER JOIN party_list ON candidate.party_list = party_list.party_id
WHERE candidate.position ='$pos_no'
AND candidate.active =1 AND position.active=1 AND party_list.active=1";
$res_cand=mysqli_query($connection,$get_cand);
while ($row_cand = mysqli_fetch_assoc($res_cand)){
    $name = $row_cand['name'];
    $cand_id = $row_cand['candidate_id'];
    $votes = $row_cand['vote'];
    $party = $row_cand['party_name'];

    if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
        echo "
        <tr>
        <td>$name ($party)</td>
        <td><a href='edit-student.php?edit=$cand_id&type=candidate'><i class='far fa-edit'></i>
        Edit</a>
        <a href='remove-student.php?remove=$cand_id&type=candidate' class='remove'";?>
        onclick="return confirm('Are you sure you want to remove this candidate? Changes cannot be undone.');">
        <i class='fas fa-user-slash'></i>
        Remove</a></td>
        </tr>
        <?php
    }
    else{ 
        echo "
        <tr>
        <td>$name ($party)</td>
        <td><a nohref='edit-student.php?edit=$cand_id&type=candidate'><i class='far fa-edit'></i>
        Edit</a>
        <a nohref='remove-student.php?remove=$cand_id&type=candidate' class='remove'> 
        <i class='fas fa-user-slash'></i>
        Remove</a></td>
        </tr>
        ";
    }
    
 }

}

?>
   
</table>
<!--TABLE END !-->

<!--ADD FORM START !-->
<div class='form' id='candidate-form' style="height:520px;">
<div class='form-header'><h2>Add Candidate</h2></div>
<form action="add_candidate.php" method="post" autocomplete='off' enctype="multipart/form-data">

<label for = 'name'>Name:</label>
<input type="text" name="name" id="name" required/>
<br>
<br>
<label for = 'position'>Position:</label>
<select name="position" id="position" required >
<option value="">Select Position</option>
<?php
    $get_position = "SELECT * FROM position WHERE active =1 ";
    $res_position = mysqli_query($connection,$get_position);
    while($row_position=mysqli_fetch_assoc($res_position)){
        $position = $row_position['pos_name'];
        $pos_id = $row_position['position_id'];
        echo "<option value='$pos_id' >$position</option>";
    }

?>
</select>
<br>
<br>
<label for = 'party_list'>Party List:</label>
<select name="party_list" id="party_list" required >
<option value="">Select Party List</option>
<?php
    $get_party = "SELECT * FROM party_list WHERE active =1";
    $res_party = mysqli_query($connection,$get_party);
    while ($row_party = mysqli_fetch_assoc($res_party)){
        $party_id = $row_party['party_id'];
        $party_name = $row_party['party_name'];
        echo "<option value='$party_id'>$party_name</option> ";
    }
?>
</select>
<br>
<br>

<label for="image-file">Image:</label>
<input type="file" name="image-file" id="image-file">
<br>
<br>
<input type="submit" value="Submit" name = 'submit-form'>
<button class='cancel' onclick='addCandidate_off();'>Cancel</button>

</form>
</div>

<!--ADD FORM END !-->


</div>
</div>
<div id="overlay" style="display:none;"></div>
</body>
</html>