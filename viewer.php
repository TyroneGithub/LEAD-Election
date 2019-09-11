<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>LEAD Election Results|View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/viewer.css">
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    xwidth: 100%;
    xheight: 100%;
  }
  </style>
</head>
<body>

<div class="container">
  <h2>LEAD Election Results</h2>
 
  
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">

 
  
  <!-- The slideshow -->
  <div class="carousel-inner">
  <div class='carousel-item active'>
      <div class='res'>
      <h2>RESULTS</h2>
      </div>
      
      <br><br>
  </div>
  <?php
    $get_pos = "SELECT * FROM position INNER JOIN candidate
    ON position.position_id = candidate.position
    WHERE position.active =1 GROUP BY position_id  ";
    $res_pos = mysqli_query($connection,$get_pos);
    while ($row_pos = mysqli_fetch_assoc($res_pos)){
        $pos_no = $row_pos['position_id'];
        $pos_name = $row_pos['pos_name'];
      
    $get_cand = "SELECT * FROM candidate
    INNER JOIN position ON candidate.position = position.position_id
    INNER JOIN party_list ON candidate.party_list = party_list.party_id
    WHERE candidate.position ='$pos_no'
    AND candidate.active =1 AND name!='abstain' ";
    $res_cand=mysqli_query($connection,$get_cand);
    
    while ($row_cand = mysqli_fetch_assoc($res_cand)){
        $pos_no = $row_pos['position_id'];
        $pos_name = $row_pos['pos_name'];
        $name = $row_cand['name'];
        $cand_id = $row_cand['candidate_id'];
        $votes = $row_cand['vote'];
        $party = $row_cand['party_name'];
        $img = $row_cand['image'];
            echo "
            <div class='carousel-item'>
            <div class='item-cont'>
            <div class='cont-img'>
            <p><img src='images/$img' >
            <br>
            $name</p>
            <p style='margin-top:-20px;'>Votes:$votes</p>
            </div>  
            <br><br><br>
            <div class='carousel-caption'>
            <h3>$pos_name</h3>
            </div>
            </div>
            </div>
            ";
    }
}?>
   <!-- Indicators -->
<ul class="carousel-indicators">
<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
<?php
    $get_cand_num = "SELECT * FROM candidate WHERE active=1";
    $res_cand_num = mysqli_query($connection,$get_cand_num);
    $count_cand = mysqli_num_rows($res_cand_num);
    for($x=1; $x<=$count_cand; $x++ ){
        echo "<li data-target='#myCarousel' data-slide-to='$x'></li>";
    }
$sec = ($count_cand + 1) *5;    

    ?>
<meta http-equiv="refresh" content="<?php echo $sec; ?>; url=viewer.php">

</ul>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

</div>

</body>
</html>
