<?php
include 'connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/sidebar-admin.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">

    
</head>
<body>
<div class = 'sidebar'>
    <div id='logo'></div>
    <div class='user'>
    
    <?php
    $username = $_SESSION['username'];

    //GET NAME OF USER LOGGED IN 
    $get_name = "SELECT * FROM users WHERE username = '$username' ";
    $name_result =  mysqli_query($connection, $get_name);
    while ($row_name = mysqli_fetch_assoc($name_result)){
        echo "Welcome ".$row_name['name'];
    }
   
    ?> </div>

    <a href='main.php?type=admin'><i class="fas fa-home"></i> Home</a>
    <a href='candidates.php'><i class="fas fa-users"></i> Candidates</a>
    <a href='students.php'><i class="fas fa-users"></i> Students</a>
    <button class='collapsible' onclick="collapse();"><i class="fas fa-cog"></i> Settings</button>
    <div class='content'>
        <a href="settings.php?page=position">Position</a>
        <a href="settings.php?page=partylist">Party List</a>
        <a href="settings.php?page=section">Section</a>
        <a href="settings.php?page=election">Election</a>
        <a href="settings.php?page=admin">Admin</a>
    </div>
<script>
    //collapsible script
var coll = document.getElementsByClassName("collapsible");
    var i;
    
    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
</script>
</div>
</body>
</html>