<?php
include 'connection.php';
session_start();
if (isset($_POST['change-pass'])){

    $old = $_POST['old'];
    $new = $_POST['new'];
    $confirm = $_POST['confirm'];
    $user_id = $_GET['user_id'];
    $get_old = "SELECT * FROM users WHERE role = 'admin' AND active =1 AND user_id='$user_id' ";
    $result_get = mysqli_query($connection,$get_old);
    while ($row=mysqli_fetch_assoc($result_get)){
        $password = $row['password'];
    }

  if  (password_verify($old,$password)){
        if($new === $confirm){
            $hash = password_hash($new,PASSWORD_DEFAULT);
            $update_password= "UPDATE users SET password = '$hash' WHERE user_id='$user_id' AND active=1 ";
            $result_update= mysqli_query($connection,$update_password);
            if ($result_update){
                $change = "&change=true";
                header("location:settings.php?page=admin$change");
                $_SESSION['pass']='';
            }
            else{
                echo "fail";
            }
        }
        else{
            $_SESSION['pass'] = "Password does not match";
            header("location:settings.php?page=admin");
        }

  }
  else{
      $_SESSION['pass'] = "Wrong Password";
      header("location:settings.php?page=admin");
  }

    



}


?>