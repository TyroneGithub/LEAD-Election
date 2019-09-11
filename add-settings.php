<?php
include 'connection.php';

if (isset($_POST['submit-form'])){

    if ($_GET['page']=='position'){
        $pos_name = $_POST['pos_name'];
        $pos_code = $_POST['pos_code'];
        $level = $_POST['level'];
        $winner = $_POST['winner'];
        
        $add_position = "INSERT INTO position (pos_name,pos_code,level,winner)
        VALUES ('$pos_name','$pos_code','$level','$winner') ";
        $res_position = mysqli_query($connection,$add_position);
        if ($res_position){
            header('location:settings.php?page=position&add=true');
        }
        else{
            echo "fail";
        }
    }
    else if ($_GET['page']=='partylist'){
        $party_name = $_POST['party_name'];
        $party_code = $_POST['party_code'];

        $add_party = "INSERT INTO party_list (party_name,party_code)
        VALUES ('$party_name','$party_code') ";
        $res_party = mysqli_query($connection,$add_party);
        if ($res_party){
           header('location:settings.php?page=partylist&add=true');
          // echo "success";
        }
        else{
            echo "fail";
        }

    }
    else if ($_GET['page']=='section'){
        $level = $_POST['level'];
        $section_name= $_POST['section_name'];

        $add_section = "INSERT INTO section (level,section_name)
        VALUES ('$level','$section_name') ";
        $res_section = mysqli_query($connection,$add_section);
        if ($res_section){
           header('location:settings.php?page=section&add=true');
          // echo "success";
        }
        else{
            echo "fail";
        }
    }

}


?>