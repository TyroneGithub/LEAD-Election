<link rel="stylesheet" href="css/admin/header.css">

<header class="header sticky" id="header-admin"> 
<div class="cont">
<span> <h1> <div class = "pos-img"> <img src="images/vectorlsqc.png" /></div>
LEAD Election System</h1> </span>

<nav class="nav"> 
<ul>
<?php
  $get_date = "SELECT * FROM schedule WHERE election = 1 AND sched_id=1";
  $result_date = mysqli_query($connection,$get_date);
  $count_date = mysqli_num_rows($result_date);
  while ($row_date = mysqli_fetch_assoc($result_date)){
      $start_date = $row_date['start_date'];
      $end_date = $row_date['end_date'];
  }
  date_default_timezone_set("Asia/Manila");
  $curr_date = date('Y-m-d');
  if ($count_date>=1){
    if ($curr_date<$start_date){
        echo "<li style='margin-right:20px; font-weight:bold;'>Election Status: <p style='display:inline-block; line-height:30px;
         color:#F08080;'>Not Set</p></li>";
    }
    else if ($curr_date>$end_date){
        echo "<li style='margin-right:20px; font-weight:bold;'>Election Status: <p style='display:inline-block; 
        line-height:30px; color:#00FA9A;'>Done</p></li>";

    }
    else{
        echo "<li style='margin-right:20px; font-weight:bold;'>Election Status: <p style='display:inline-block; line-height:30px; 
        color:#00FA9A;'>Ongoing</p></li>";

    }
 }
  else{
    echo "<li style='margin-right:20px; font-weight:bold;'>Election Status: <p style='display:inline-block; line-height:30px; 
    color:#F08080;'>Not Set</p></li>";

  }
?>
   
    <li><a href="login.php?method=logout"> <i class="fas fa-sign-out-alt"></i>Log out  </a></li>
    
</ul>
</nav>
</div>
</header>
