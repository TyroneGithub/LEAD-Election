<?php
include 'connection.php';

if (isset($_POST['elect'])){
    $id = $_GET['id'];
    $get_voter_id = "SELECT * FROM users WHERE user_id = '$id' AND active=1  ";
    $res_id = mysqli_query($connection,$get_voter_id);
    while($row_id = mysqli_fetch_assoc($res_id)){
        $voter_id = $row_id['username'];
    }
// get position that requires 2 or more winners
$get_position2 = "SELECT * FROM position WHERE winner>=2 AND active=1";
$res_position2 = mysqli_query($connection,$get_position2);
while($row_pos2=mysqli_fetch_assoc($res_position2)){
    $position_id = $row_pos2['position_id'];
    $winner = $row_pos2['winner'];
    $get_candidate = "SELECT DISTINCT position FROM candidate 
    WHERE active =1 AND position !='$position_id' ";
    $res_candidate = mysqli_query($connection,$get_candidate);
    if(!empty($_POST["$position_id"])) {
        foreach($_POST["$position_id"] as $check) {
        // 2 or more winners
        $up_voteA = "UPDATE candidate SET vote = vote+1 WHERE candidate_id = $check";
        $result_voteA = mysqli_query($connection, $up_voteA);
      
        }
    }

}
     //get positions of candidates except those with 2 or more winners
    
    while ($row_cand = mysqli_fetch_assoc($res_candidate)){
        $pos_id = $row_cand['position'];
            $pos = $_POST["$pos_id"];
            // update votes
            $up_voteB = "UPDATE candidate SET vote = vote+1 WHERE candidate_id = '$pos' ";
            $result_voteB = mysqli_query($connection, $up_voteB);
     
        
        }


    
    $up_response = "INSERT INTO response (voter_id) VALUES ('$voter_id') ";
    $res_response = mysqli_query($connection,$up_response);
    if ($res_response and $result_voteA and $result_voteB){
        header('location:main.php?type=student');
        echo "success";
    }
    else{
     //header("location:election.php?id=$id");
        }
    
    } else{
   // header("location:election.php?id=$id");
        }
    

  

    

    
    
    


?>