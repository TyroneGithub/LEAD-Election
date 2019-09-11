<?php
include 'connection.php';

if($_GET['type']=='student'){
    $user_id = $_GET['remove'];

    $remove_user = "UPDATE users SET active = 0 WHERE user_id ='$user_id' ";
    $result_remove= mysqli_query($connection,$remove_user);
    
    $get_section = "SELECT * FROM users WHERE user_id='$user_id'  ";
    $result_section = mysqli_query($connection,$get_section);
    while($row_section = mysqli_fetch_assoc($result_section)){
        $section = $row_section['section'];
    }
    
    
        if ($result_remove){
            header("location:student-list.php?sec_id=$section");
            echo "success";
        }
        else{
            echo "fail";
        }
}
else if ($_GET['type']=='candidate'){
    $cand_id=$_GET['remove'];
    $remove_candidate = "UPDATE candidate SET active=0 WHERE candidate_id = $cand_id ";
    $result_remove_candidate = mysqli_query($connection,$remove_candidate);
    if ($result_remove_candidate){
        header("location:candidates.php");
    }
    else{
        echo "fail";
    }
}

?>