<?php
include 'connection.php';

$remove_all = "UPDATE users SET active = 0 WHERE role='student' AND active = 1";
$res_remove = mysqli_query($connection, $remove_all);
if ($res_remove){
    header('location:students.php?remove=true');
}
else{
    echo "fail";
}





?>