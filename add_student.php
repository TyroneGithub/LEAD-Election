<?php
include 'connection.php';
$username = mysqli_real_escape_string($connection,$_POST['username']);
$name =  mysqli_real_escape_string($connection,$_POST['name']);
$section = $_POST['section'];
$password =  mysqli_real_escape_string($connection,$_POST['password']);

$hash = password_hash($password,PASSWORD_DEFAULT);
if (isset($_POST['submit-form'])){

    $get_student = "SELECT * FROM users WHERE username ='$username'  ";
    $result_student = mysqli_query($connection,$get_student);
    $count_student = mysqli_num_rows($result_student);
    if ($count_student>=1){
        $update_student = "UPDATE users SET username='$username', name='$name',
        section='$section', password='$hash', active=1  WHERE username='$username' ";
        $result_update = mysqli_query($connection,$update_student);
            if ($result_update){
                header('location:students.php?add=true');
            }
            else{
                echo "An error has occured";
            }
    }
    else{
        $add_student = "INSERT INTO users (username,name,section,role,password)
        VALUES ('$username', '$name','$section','student','$hash') ";
        $result_add = mysqli_query($connection,$add_student);
        if ($result_add){
            header('location:students.php?add=true');
        }
        else {
            echo "An error has occured";
        }
    }

 
}
else{
    echo "An error has occured";
}


?>