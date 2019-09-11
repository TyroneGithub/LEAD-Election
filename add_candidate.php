<?php
include 'connection.php';
$name = mysqli_real_escape_string($connection,$_POST['name']);
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
    if (isset($_POST['submit-form'])){
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
        }else{
            if ($upload_image){
                $add_student = "INSERT INTO candidate (name,position,party_list,image) VALUES ('$name','$position','$party','$filename') ";
                $result_add = mysqli_query($connection,$add_student);
                if ($result_add){
                    header('location:candidates.php?add=true');
               
                }
                else {
                    echo "fail1";
                }
            }
            else{
                $add_student = "INSERT INTO candidate (name,position,party_list) VALUES ('$name','$position','$party') ";
                $result_add = mysqli_query($connection,$add_student);
                if ($result_add){
                    header('location:candidates.php?add=true');
               
                    }
                else {
                    echo "fail2";
                    }
                }

          
        }
     
    }

?>