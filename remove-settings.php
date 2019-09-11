<?php
include 'connection.php';

    if (isset($_GET['remove'])){
        if ($_GET['page']=='position'){
            $pos_id = $_GET['pos_id'];
         
            $remove_pos = "UPDATE position SET active = 0 WHERE position_id = $pos_id
            AND active =1 ";
            $result_remove = mysqli_query($connection,$remove_pos);
            if ($result_remove){
                header('location:settings.php?page=position');
            }
            else{
                echo "fail";
            }
        }
        else if ($_GET['page']=='partylist'){
            $party_id = $_GET['party_id'];
            $remove_party = "UPDATE party_list SET active = 0 WHERE party_id = $party_id
            AND active =1 ";
            $result_remove = mysqli_query($connection,$remove_party);
            if ($result_remove){
                header('location:settings.php?page=partylist');
            }
            else{
                echo "fail";
            } 
        }
        else if ($_GET['page']=='section'){
            $section_id = $_GET['section_id'];
            $remove_section = "UPDATE section SET active = 0 WHERE section_id = $section_id
            AND active =1 ";
            $result_remove = mysqli_query($connection,$remove_section);
            if ($result_remove){
                header('location:settings.php?page=section');
            }
            else{
                echo "fail";
            }
        }
    }




?>