<?php
include 'connection.php';

if ($_GET['type']=='student'){
    $name =  mysqli_real_escape_string($connection,$_POST['name']);
    $section = $_POST['section'];
    $user_id = $_GET['id'];
    if (isset($_POST['edit-form'])){
        $edit_student = "UPDATE users SET name='$name' , section='$section'
        WHERE user_id='$user_id' ";
        $res_edit = mysqli_query($connection,$edit_student);
        if ($res_edit){
           header("location:edit-student.php?edit=$user_id&type=student&edited=true");
        }
        else {
            echo "fail";
        }
    }
    
}
else if ($_GET['type']=='candidate'){
    $cand_id = $_GET['id'];
    $name =  mysqli_real_escape_string($connection,$_POST['name']);
    $position = $_POST['position'];
    $party = $_POST['party_list'];

    $target_dir = "images/";
    $uploadOk = 1;
    $temp = explode(".", basename($_FILES["image-file"]["name"]));
    $nameB = pathinfo($_FILES["image-file"]["name"],PATHINFO_FILENAME);
    $filename = strtolower("$nameB").".".end($temp);
    $target_file = $target_dir.$filename;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $upload_image = move_uploaded_file($_FILES["image-file"]["tmp_name"],$target_file);
    if (isset($_POST['edit-candidate'])){
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        else{
            if ($upload_image){
                $edit_candidate = "UPDATE candidate SET name ='$name' , position='$position', party_list ='$party', image='$filename'
                WHERE candidate_id = '$cand_id' ";
                $res_edit_cand = mysqli_query($connection,$edit_candidate);
                if ($res_edit_cand){
                    header("location:edit-student.php?edit=$cand_id&type=candidate&edited=true");
                }
            }
            else{
                $edit_candidate_noimg = "UPDATE candidate SET name ='$name' , position='$position', party_list ='$party'
                WHERE candidate_id = '$cand_id' ";
                $res_edit_cand_noimg = mysqli_query($connection,$edit_candidate_noimg);
                if ($res_edit_cand_noimg){
                    header("location:edit-student.php?edit=$cand_id&type=candidate&edited=true");  
                }
            
            else{
                echo "fail";
                }
            }       
            
         
        }
   
    }
    else{
        echo "fail1";
    }
}
else {
    echo "fail";
    }




?>