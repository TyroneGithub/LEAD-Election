<?php
include 'connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/sidebar.css">
</head>
<body>
<div class = 'sidebar'>
   
    <div class='user'>
    
    <?php
    $username = $_SESSION['username'];

    //GET NAME OF USER LOGGED IN 
    $get_name = "SELECT * FROM users WHERE username = '$username' ";
    $name_result =  mysqli_query($connection, $get_name);
    while ($row_name = mysqli_fetch_assoc($name_result)){
        echo "Voter name: <br><br>".$row_name['name'];
    }
   
    ?> </div>

    <a href='main.php?type=student'>Home</a>
    
</div>
</body>
</html>