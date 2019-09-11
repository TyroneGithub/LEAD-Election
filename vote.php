<?php
include 'connection.php';
$v = $_POST['president'];

$query = "SELECT * FROM candidate";
$result = mysqli_query($connection,$query);
while ($row=mysqli_fetch_assoc($result)){
    $cand_id = $row['candidate_id'];

    
}
if ($v == $cand_id ){
        $update = "UPDATE candidate SET vote = vote+1 ";
        mysqli_query($connection,$update);
}

?>