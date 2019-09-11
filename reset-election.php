<?php
include 'connection.php';
if (isset($_GET['reset'])){
    $remove_results = 'UPDATE candidate SET vote = 0 ';
    $result_remove = mysqli_query($connection,$remove_results);
    $truncate_response = "TRUNCATE TABLE response";
    $result_truncate = mysqli_query($connection,$truncate_response);

    if ($result_remove and $result_truncate){
        header('location:main.php?type=admin');
    }
    else {
        echo "fail";
    }
}

?>