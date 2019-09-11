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
    <link rel="stylesheet" href="css/admin/edit-student.css">
    <link rel="stylesheet" href="css/admin/edit-overlay.css">
    <script src="js/status-overlay.js"></script>
    <title>
        <?php
    if ($_GET['type']=='student'){
        $user_id = $_GET['edit'];
        $get_student = "SELECT * FROM users INNER JOIN section ON
        users.section = section.section_id 
        WHERE user_id = $user_id AND users.active =1 AND section.active=1";
        $res_student = mysqli_query($connection,$get_student);
        while($row_student = mysqli_fetch_assoc($res_student)){
            $student_no=$row_student['username'];
            $name = $row_student['name'];
            $section_id=$row_student['section'];
            $section_name = $row_student['section_name'];
            $year_level = $row_student['level'];
            echo $name; 
        }
    }
    else if($_GET['type']=='candidate'){
        $cand_id = $_GET['edit'];
        $get_candidate = "SELECT * FROM candidate INNER JOIN position ON
        candidate.position = position.position_id 
        INNER JOIN party_list ON candidate.party_list = party_list.party_id
        WHERE candidate.active =1 AND candidate_id = '$cand_id' AND position.active=1
        AND party_list.active=1 ";
        $result_candidate = mysqli_query($connection,$get_candidate);

        while($row_cand=mysqli_fetch_assoc($result_candidate)){
            $name = $row_cand['name'];
            $position = $row_cand['pos_name'];
            $pos_id = $row_cand['position_id'];
            $party_list = $row_cand['party_name'];
            $party_candidate_id = $row_cand['party_list'];
            $img = $row_cand['image'];
            echo $name;
        }
    }
     
        ?>
    </title>
</head>
<body>
<?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>
<div class='main-wrap'>
<div class='box'>

<?php 
    if (isset($_GET['edited'])){
?>
    <body onload="editSuccess_on();">
    </body>
  <?php  }
    ?>
    <div id='status-overlay'><div id='status-box'>
        <h2>
        <img src='images/green-check.png'/>
        <br>
        
        Edited Successfully!
       
        </h2>
        <button onclick='edit_off();'>Close</button>
        </div></div>



<?php
    if ($_GET['type']=='student'){

?> 
<h2><a href="student-list.php?sec_id=<?php 
echo $section_id;
?>" class='back'><i class="fas fa-arrow-left"></i></a>
    Edit Student</h2>

<div class='form'>
<div class='form-header'><h2>Edit Student</h2></div>
<form action="edit-student_validate.php?id=<?php echo "$user_id&type=student"; ?>" 
method="post" autocomplete='off'>
<label for = 'student-no'>Student Number:</label>
<input type="text" name="username" id="student-no" value='
<?php echo $student_no;?>
' readonly/>
<br>
<br>
<label for = 'name'>Name:</label>
<input type="text" name="name" id="name" 
value='
<?php echo $name;?>'
/>
<br>
<br>
<label for = 'section'>Section:</label>
<select name="section" id="section" required >
<option value="<?php
echo "$section_id";
?>"><?php echo "$year_level-$section_name";?> </option>
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

<input type="submit" value="Edit" name = 'edit-form'>


</form>

</div>
<?php } 
else if ($_GET['type']=='candidate') {

?> 
<h2><a href="candidates.php" class='back'><i class="fas fa-arrow-left"></i></a>
    Edit Candidate</h2>

<div class='form' style="height:700px;" >
<div class='form-header'><h2>Edit Candidate</h2></div>
<form action="edit-student_validate.php?id=<?php echo "$cand_id&type=candidate"; ?>" 
method="post" autocomplete='off' enctype="multipart/form-data" >
<label for = 'name'>Name:</label>
<input type="text" name="name" id="name" 
value='
<?php echo  mysqli_real_escape_string($connection,$name);?>'
/>
<br>
<br>
<label for = 'position'>Position:</label>
<select name="position" id="position"  >
<option value="<?php
echo "$pos_id";
?>"><?php echo "$position";?> </option>
<?php
    $get_position = "SELECT * FROM position WHERE active =1 ";
    $res_position = mysqli_query($connection,$get_position);
    while($row_position=mysqli_fetch_assoc($res_position)){
        $position_id = $row_position['position_id'];
        $pos_name = $row_position['pos_name'];
        echo "<option value='$position_id' >$pos_name</option>";
    }

?>
</select>

<br>
<br>
<label for = 'party_list'>Party List:</label>
<select name="party_list" id="party_list" required >
<option value="<?php echo $party_candidate_id; ?>"><?php echo $party_list; ?></option>
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
<label for="image-file">Image:
<br>
    <div class='candidate'><img src="images/<?php echo "$img"  ?>" alt="candidate image" ></div> 
</label>

<input type="file" name="image-file" id="image-file" value="<?php echo $img; ?>">

<input type="submit" value="Edit" name = 'edit-candidate'>


</form>

</div>


<?php }
?>
</div>
</div>



</body>
</html>