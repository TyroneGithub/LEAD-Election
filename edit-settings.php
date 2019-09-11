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
    <link rel="stylesheet" href="css/admin/edit-settings.css">
    <link rel="stylesheet" href="css/admin/edit-overlay.css">
    <script src="js/status-overlay.js"></script>
</head>
<body>
<?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>

<div class='main-wrap'>
<div class='box'>
<?php 
    if (isset($_GET['edit'])){
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
<h2>
<a href="settings.php?page=<?php echo $_GET['page']; ?>" class='back'>
<i class="fas fa-arrow-left"></i></a>
<?php
    if (empty($_GET['page'])){
        $_GET['page']='default';
    }
    // POSITION EDIT START
    else if ($_GET['page']=='position'){
   ?> 
    <title>

    <?php
    $pos_id = $_GET['pos_id'];
    $get_position="SELECT * FROM position WHERE active =1 AND position_id='$pos_id' ";
    $res_position = mysqli_query($connection,$get_position);
    while($row_position = mysqli_fetch_assoc($res_position)){
        $pos_name = $row_position['pos_name'];
        $pos_code = $row_position['pos_code'];
        $level_pos = $row_position['level'];
        $winner = $row_position['winner'];
        echo $pos_name;
    }
    ?>
    </title>

Edit Position</h2>
<!-- FORM START !-->
<div class='form' style="height:475px;">
<div class='form-header'><h2>Edit Position</h2></div>
<form action="edit-settings-validate.php?id=<?php echo "$pos_id&page=position"; ?>" 
method="post" autocomplete='off'>
<label for = 'student-no'>Position Name:</label>
<input type="text" name="pos_name" id="student-no" value='
<?php echo $pos_name;?>
'/>
<br>
<br>
<label for = 'name'>Position Code:</label>
<input type="text" name="pos_code" id="name" 
value='
<?php echo $pos_code;?>'
/>
<br>
<br>
<label for = 'level'>Grade Level:</label>
<select name="level_pos" id="level" required >
<option value="<?php
echo "$level_pos";
?>"><?php echo "$level_pos";?> </option>
<?php
    for($i=7; $i<=12; $i++){
        echo "<option value='$i'>$i</option>";
    }

?>
</select>
<br>
<br>
<label for = 'winner'>No. of Winners:</label>
<input type="number" name="winner" id="winner" value="<?php echo "$winner";?>" required/>
<input type="submit" value="Edit" name = 'edit-form'>


</form>

</div>
<!-- FORM END !-->
<?php }

else if($_GET['page']=="partylist"){
    ?> 
    

Edit Party List</h2>
<title>
    <?php
    $party_id = $_GET['party_id'];
    $get_party="SELECT * FROM party_list WHERE active =1 AND party_id='$party_id' ";
    $res_party = mysqli_query($connection,$get_party);
    while($row_party = mysqli_fetch_assoc($res_party)){
        $party_name = $row_party['party_name'];
        $party_code = $row_party['party_code'];
        
        echo $party_name;
    }
    ?>
    </title>
<!-- FORM START !-->
<div class='form'>
<div class='form-header'><h2>Edit Party List</h2></div>
<form action="edit-settings-validate.php?id=<?php echo "$party_id&page=partylist"; ?>" 
method="post" autocomplete='off'>
<label for = 'student-no'>Party List Name:</label>
<input type="text" name="party_name" id="student-no" value='
<?php echo $party_name;?>
'/>
<br>
<br>
<label for = 'name'>Party List Code:</label>
<input type="text" name="party_code" id="name" 
value='
<?php echo $party_code;?>'
/>

<input type="submit" value="Edit" name = 'edit-form'>


</form>

</div>
<!-- FORM END !-->
<!-- PARTY LIST SETTINGS END !-->
<?php

}
else if ($_GET['page']=='section'){
?> 
Edit Section</h2>
<title>
    <?php
    $section_id = $_GET['section_id'];
    $get_section="SELECT * FROM section WHERE active =1 AND section_id='$section_id' ";
    $res_section = mysqli_query($connection,$get_section);
    while($row_section = mysqli_fetch_assoc($res_section)){
        $section_name = $row_section['section_name'];
        $level_section = $row_section['level'];
        
        echo $section_name;
    }
    ?>
    </title>
<!-- FORM START !-->
<div class='form'>
<div class='form-header'><h2>Edit Party List</h2></div>
<form action="edit-settings-validate.php?id=<?php echo "$section_id&page=section"; ?>" 
method="post" autocomplete='off'>
<label for = 'level'>Grade Level:</label>
<select name="level_section" id="level">
<option value="<?php echo $level_section ?>"><?php echo $level_section ?></option>
<?php
 for ($i=7; $i<=12; $i++){
     echo "<option value='$i'>$i</option>";
 }
?>
</select>

<br>
<br>
<label for = 'student-no'>Section Name:</label>
<input type="text" name="section_name" id="student-no" value='
<?php echo $section_name;?>
'/>



<input type="submit" value="Edit" name = 'edit-form'>


</form>

</div>

<?php }

?>

    
</div>
</div>
</body>
</html>