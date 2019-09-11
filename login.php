<?php
include 'connection.php';

if ($_GET['method']=='login'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
if (isset($username) and isset($password)){
    $query = "SELECT * FROM users WHERE username = '$username'  ";
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);
    session_start();
  //  $hash = password_hash($password,PASSWORD_DEFAULT);
    if ($count>=1){
       
        while ($row = mysqli_fetch_assoc($result)){
            $pass=$row['password'];
            $role = $row['role'];
        if (password_verify($password, $pass)){
            if ($role == 'student'){
                header('location:main.php?type=student');
                
            }
            else {
                header('location:main.php?type=admin');
            }
            $_SESSION['username']=$username;
            $_SESSION['type']= $role;
        }
        else{
            echo "ww";
        }
        
        }
    }
    else { 
        header('location:index.php');
    }
  
  
}

}
else if ($_GET['method']=='logout') {
    session_start();

    session_unset();
    session_destroy();
    $_SESSION['msg'];
   

 header('location:index.php');
}




