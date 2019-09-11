<?php
include 'connection.php';

if (isset($_POST['add-admin'])){
    $name=$_POST['name'];
    $username=$_POST['username'];
    $password=$_POST['password'];

    $hash = password_hash($password,PASSWORD_DEFAULT);
    $add_admin = "INSERT INTO users (username,name,password,role) VALUES ('$username','$name','$hash','admin')";
    $result_add = mysqli_query($connection,$add_admin);
    if ($result_add){
        header('location:settings.php?page=admin&add=true');
    }
    else{
        echo "fail";
    }
}

?>