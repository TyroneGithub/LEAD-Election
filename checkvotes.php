<?php
include 'connection.php';
session_start();
if (empty($_SESSION['username'])){
    header('location:index.php'); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/voter/voting.css">
    <link rel="stylesheet" href="css/election/css/main.css" title='main'>
    <link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
    <title>Confirm votes</title>
</head>
<body>
    <?php
    include 'header-voter.php';
    include 'sidebar-voter.php';
    ?>
    <div class = 'container'>
<div class="page-wrapper  p-t-45 p-b-50">
<div class="wrapper wrapper--w960">
<div class="card card-5">
                <div class="card-heading">
                <h3 class="title">LEAD Election</h3>
                </div>
                <div class="card-body">

    <?php 
if (isset($_POST['elect'])){
?>
 <form action="validate_election.php?id=<?php 
 echo $_GET['id']; ?>" 
 onsubmit="return confirm('Are you sure you want to proceed with your votes? This action cannot be undone.')" required>
 <?php
    $get_pos = "SELECT * FROM position INNER JOIN candidate
    ON position.position_id = candidate.position
    WHERE position.active =1 GROUP BY position_id  ";
    $res_pos = mysqli_query($connection,$get_pos);
    while ($row_pos = mysqli_fetch_assoc($res_pos)){
        $pos_no = $row_pos['position_id'];
        $pos_name = $row_pos['pos_name'];
        $winner = $row_pos['winner'];
        echo "<br><div class='pos-name' style='display:block;'> ".$pos_name."</div><br>";



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
        $get_vote = "SELECT * FROM candidate INNER JOIN party_list 
        ON candidate.party_list = party_list.party_id
         WHERE candidate_id = '$check' AND candidate.active=1 AND position='$pos_no' ";
        $res_vote = mysqli_query($connection,$get_vote);
        while($row_vote = mysqli_fetch_assoc($res_vote)){
            $name = $row_vote['name'];
            $img = $row_vote['image'];
            $party = $row_vote['party_name'];
            echo "
           
            <div class = 'radio-cont'>
            <label class='cand-label' >
            <img src = 'images/$img' alt='candidate image'>
            <p>
            $name
            <input type='hidden' name = '$pos_no' value='$pos_no'/>
            <br>
            ($party)
            <br>
            
            </p>
            </label>
            </div>
            ";
            }
        }
    }

}
     //get positions of candidates except those with 2 or more winners
    
    while ($row_cand = mysqli_fetch_assoc($res_candidate)){
            $pos_id = $row_cand['position'];
            $pos = $_POST["$pos_id"];
            $get_vote2 = "SELECT * FROM candidate INNER JOIN party_list 
            ON candidate.party_list = party_list.party_id
            WHERE candidate_id = '$pos' AND candidate.active=1 AND party_list.active=1 AND  position='$pos_no' ";
            $res_vote2 = mysqli_query($connection,$get_vote2);
            while($row_vote2 = mysqli_fetch_assoc($res_vote2)){
                $name2 = $row_vote2['name'];
                $img2 = $row_vote2['image'];
                $party2=$row_vote2['party_name'];
                echo "
           
                <div class = 'radio-cont' style='margin-left:250px;'>
                <label class='cand-label' >
                <img src = 'images/$img2' alt='candidate image'>
                <p>
                $name2
                <input type='hidden' name = '$pos_no' value='$pos_no'/>
                <br>
                ($party2)
                <br>
                
                </p>
                </label>
                </div>
                ";
            }
        }

}
}
?>
<input  class='btn btn--radius-2 btn--blue' type="submit" value="Submit" name="elect">
</form>
</div>
</div>
</div>
</body>
</html>
