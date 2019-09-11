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
    <link rel="stylesheet" href="css/voter/home.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <?php
date_default_timezone_set("Asia/Manila");
if (empty($_GET['type'])){
    header('location:index.php');
}
else if ($_GET['type']=='student' and $_SESSION['type']=='student'){
    
    include 'header-voter-main.php';
    include 'sidebar-voter.php';
    echo '<title>LEAD Elections</title>';
    $username = $_SESSION['username'];
    //get user grade level
    $get_level = "SELECT * FROM users WHERE username='$username' AND active =1 ";
    $result_level = mysqli_query($connection, $get_level);
    while($row_level=mysqli_fetch_assoc($result_level)){
     
        $id = $row_level['user_id'];
    }
   
    ?>
      <?php
    $get_response = "SELECT * FROM response INNER JOIN users ON
    response.voter_id = users.username 
    WHERE voter_id = '$username'  AND users.active = 1  ";
    $result_response =  mysqli_query($connection, $get_response);
    $count_response = mysqli_num_rows($result_response);
    
    if ($count_response>=1){
        
    ?> 
    <a nohref="election.php?id=<?php
        echo $id;
    ?>">
    
    <div id ='card'>
  
    <div class='image'><img src="images/voting.png" alt="Voting"></div>
    <h2>LEAD Election 
    <i class="fas fa-check-circle" style="color:green"></i>
    </h2>
    </div>
    </a>

    <?php }
    else{
    
        $curr_date = date('Y-m-d');
        $get_date = "SELECT * FROM schedule WHERE sched_id=1";
        $result_date= mysqli_query($connection,$get_date);
        $count_date = mysqli_num_rows($result_date);
        if($count_date>=1){
            while($row_date = mysqli_fetch_assoc($result_date)){
                $start_date = $row_date['start_date'];
                $end_date = $row_date['end_date'];
                $election = $row_date['election'];
                $drafting = $row_date['drafting'];
                if ( $election ==0 or (($curr_date<$start_date) or ($curr_date>$end_date))){
                   ?>
                   
                 <a nohref="election.php?id=<?php
                    echo $id;?>">
            
                <div id ='card'>
      
                <div class='image'><img src="images/voting.png" alt="Voting"></div>
                <h2>LEAD Election</h2>
                </div>

                </a>
                <h2 style='color:red; margin-left:380px;'>Election is not set </h2>
                <?php
                }
                else{
                   
                    ?>
                    <a href="election.php?id=<?php
                       echo $id;?>">
                   <div id ='card'>
     
                   <div class='image'><img src="images/voting.png" alt="Voting"></div>
                   <h2>LEAD Election</h2>
                   </div>
                   </a>
       
                   <?php
                }

            }
        }
        else{
            ?>
              <a nohref="election.php?id=<?php
                    echo $id;?>">
            
                <div id ='card'>
      
                <div class='image'><img src="images/voting.png" alt="Voting"></div>
                <h2>LEAD Election</h2>
                </div>

                </a>
                <h2 style='color:red; margin-left:380px;'>Election is not set</h2>
    <?php
        }
    }
    ?>
  
    
  

<?php }

else if($_GET['type']=='admin' and $_SESSION['type']=='admin'){
include 'header-admin.php';
include 'sidebar-admin.php';
  ?>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/admin/main.css">


<div class="main-wrap">

<div class='box'>
<h2>Admin Dashboard</h2>
<h3>Election Results</h3>
<a href="election-results.php" style="float:right;" id='print' target="_blank">[<i class="fas fa-print"></i>Print Results]</a>
<a href="election-winners.php" style="float:right;" id='print' target="_blank">[<i class="fas fa-print"></i>Print Winners]</a>

<?php
$get_students = "SELECT * FROM users WHERE role='student' AND active=1 ";
$result_student = mysqli_query($connection,$get_students);
$count_student = mysqli_num_rows($result_student);

$get_voted = "SELECT * FROM users INNER JOIN response
ON users.username = response.voter_id
WHERE role='student' AND users.active=1 AND response.active=1 ";
$result_voted = mysqli_query($connection,$get_voted);
$count_voted = mysqli_num_rows($result_voted);
?>
Voter Count: <?php echo "$count_voted/$count_student"; ?>
<table>
<tr>
<th>Candidate</th>
<th>Votes</th>
</tr>

<?php

$get_pos = "SELECT * FROM position INNER JOIN candidate
ON position.position_id = candidate.position
WHERE position.active =1 GROUP BY position_id  ";
$res_pos = mysqli_query($connection,$get_pos);
while ($row_pos = mysqli_fetch_assoc($res_pos)){
    $pos_no = $row_pos['position_id'];
    $pos_name = $row_pos['pos_name'];
    echo "<tr>
    <th class='position'>$pos_name</th>
    <th class='position'></th>
    </tr>";
$get_cand = "SELECT * FROM candidate
INNER JOIN party_list ON candidate.party_list = party_list.party_id
WHERE candidate.position ='$pos_no'
AND candidate.active =1 AND name!='abstain' ORDER BY vote DESC ";
$res_cand=mysqli_query($connection,$get_cand);
while ($row_cand = mysqli_fetch_assoc($res_cand)){
    $name = $row_cand['name'];
    $cand_id = $row_cand['candidate_id'];
    $votes = $row_cand['vote'];
    $party = $row_cand['party_name'];
    echo "
    <tr>
    <td>$name ($party)</td>
    <td>$votes</td>
    </tr>";
}
$get_abstain = "SELECT * FROM candidate INNER JOIN position 
ON candidate.position = position.position_id 
INNER JOIN party_list ON candidate.party_list = party_list.party_id
WHERE candidate.position ='$pos_no'
AND candidate.active =1 AND name='abstain' ORDER BY vote DESC ";
$res_abstain = mysqli_query($connection,$get_abstain);
while($row_abstain = mysqli_fetch_assoc($res_abstain)){
    $abstain_name = $row_abstain['name'];
    $abstain_party = $row_abstain['party_name'];
    $abstain_votes = $row_abstain['vote'];
    echo "
        <tr>
        <td>$abstain_name ($abstain_party)</td>
        <td>$abstain_votes</td>
        </tr>
    ";
    }
$get_sum = "SELECT SUM(vote) AS vote_sum FROM candidate WHERE position='$pos_no' AND active=1";
$res_sum = mysqli_query($connection,$get_sum);
while($row_sum = mysqli_fetch_assoc($res_sum)){
    $sum = $row_sum['vote_sum'];
    echo "
        <tr>
        <td style='float:right; color:green; font-weight:bold;'>Total:</td>
        <td>$sum</td>
        </tr>
    ";
    }
}

?>


</table>
</div>
</div>


<?php }?>
</body>
</html>
