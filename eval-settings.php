<?php
include 'connection.php';

    $start = $_POST['start'];
    $end = $_POST['end'];
    $election = $_POST['election'];
    $drafting = $_POST['drafting'];

if (isset($_POST['submit-date'])){
    

    $up_date = "UPDATE schedule SET election='$election', drafting='$drafting', start_date='$start',
    end_date ='$end' WHERE sched_id = 1 ";
    $result_update = mysqli_query($connection,$up_date);
    if ($result_update){
        header('location:settings.php?page=election');
    }
    else {
        echo "fail";
    }

}


?>