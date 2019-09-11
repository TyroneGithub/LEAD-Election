<?php
include 'connection.php';

if (isset($_POST['edit-form'])){
    if ($_GET['page']=='position'){
        $pos_name = $_POST['pos_name'];
        $pos_code = $_POST['pos_code'];
        $level_pos = $_POST['level_pos'];
        $winner = $_POST['winner'];
        $pos_id = $_GET['id'];
        $edit_pos = "UPDATE position SET pos_name='$pos_name', 
        pos_code = '$pos_code', level='$level_pos', winner=$winner
        WHERE position_id = '$pos_id' AND active=1 ";
        $res_pos = mysqli_query($connection,$edit_pos);
        if ($res_pos){
           header("location:edit-settings.php?page=position&pos_id=$pos_id&edit=true");
        }
        else {
            echo "fail";
        }
    }
    else if ($_GET['page']=='partylist'){
        $party_name = $_POST['party_name'];
        $party_code = $_POST['party_code'];
        $party_id = $_GET['id'];

        $edit_party = "UPDATE party_list SET party_name = '$party_name',
        party_code = '$party_code' WHERE party_id ='$party_id' AND active=1 ";
        $res_party = mysqli_query($connection,$edit_party);
        if ($res_party){
            header("location:edit-settings.php?page=partylist&party_id=$party_id&edit=true");
        }
        else{
            echo "fail";
        }
    }
    else if ($_GET['page']=='section'){
        $level_section = $_POST['level_section'];
        $section_name = $_POST['section_name'];
        $section_id = $_GET['id'];

        $edit_section = "UPDATE section SET section_name='$section_name',
        level = '$level_section' WHERE section_id ='$section_id' AND active=1  ";
        $res_section = mysqli_query($connection,$edit_section);
        if ($res_section){
            header("location:edit-settings.php?page=section&section_id=$section_id&edit=true");
        }
        else{
            echo 'fail';
        }
    }
}


?>