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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>LEAD Election</title>
    <script src="js/overlay.js"></script>
    <script>


    </script>


</head>
<body > 
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
<form action="validate_election.php?id=<?php
echo $_GET['id'];
?>"  method="post" 
onsubmit="return confirm('Are you sure you want to proceed with your votes? This action cannot be undone.')" required>
   

<?php
/*"validate_election.php?id=<?php
echo $_GET['id'];
?>"
return confirm('Are you sure you want to proceed with your votes? This action cannot be undone.')
*/

 $user_id = $_GET['id'];
 
 if (!isset($_GET['id'])){

 }
 else if (isset($_GET['id'])){


        $get_pos = "SELECT * FROM position INNER JOIN candidate
        ON position.position_id = candidate.position
        WHERE position.active =1 GROUP BY position_id  ";
        $res_pos = mysqli_query($connection,$get_pos);
        while ($row_pos = mysqli_fetch_assoc($res_pos)){
            $pos_no = $row_pos['position_id'];
            $pos_name = $row_pos['pos_name'];
            $winner = $row_pos['winner'];
            echo "<br><div class='pos-name' style='display:block;'> ".$pos_name." <p style='color:#DC143C; display:inline-block;'>
            (choose $winner)</p></div><br>";

            ?>


<?php

        $get_cand = "SELECT * FROM candidate INNER JOIN position 
        ON candidate.position = position.position_id 
        INNER JOIN party_list ON candidate.party_list = party_list.party_id
        WHERE candidate.position ='$pos_no'
        AND candidate.active =1 AND position.active=1 AND party_list.active=1";
        $res_cand=mysqli_query($connection,$get_cand);
        while ($row_cand = mysqli_fetch_assoc($res_cand)){
            $name = $row_cand['name'];
            $cand_id = $row_cand['candidate_id'];
            $candidate_name = $row_cand['name'];
            $party = $row_cand['party_name'];
            $img = $row_cand['image'];
            echo "
            <label  for='$cand_id'>
            <div class = 'radio-cont'>
            <label class='cand-label' for='$cand_id'>
            <img src = 'images/$img' alt='candidate image'>
            <p>
            $name
            <br>
            ($party)
            <br>
            
            </p>
            </label>
            ";
    ?> 
    
   
    <?php
            if ($winner>=2){
                echo"<input class='single-checkbox-$pos_no' 
                type ='checkbox' name='$pos_no"."[]'" ."value='$cand_id' id='$cand_id' required/>
                </div>
                </label>";
         
                ?>


<script>
var limit = <?php echo $winner;?>;
    $('.single-checkbox-<?php echo $pos_no; ?>').on('change', function() {
     
        if($('.single-checkbox-<?php echo $pos_no; ?>:checked').length> <?php echo $winner;?>) {
        this.checked = false;
        console.log("<?php echo $winner ?>");
        }
        if ($('.single-checkbox-<?php echo $pos_no; ?>:checked').length>= <?php echo $winner;?>){
            $('.single-checkbox-<?php echo $pos_no; ?>').removeAttr('required');
        }
        else{
            $('.single-checkbox-<?php echo $pos_no; ?>').attr('required', 'required');
        }
    });
</script>
            <?php }
            else{
               echo "<input type ='radio' name='$pos_no' value='$cand_id' id='$cand_id' required/>
                </div>
                </label>";
            }?>

<script> 
    $(document).ready(function(){
        $("input[type='radio']").click(function(){
            var radioValue = $("input[name='<?php echo $cand_id; 
            ?>']:checked").val();
            if(radioValue){
            <?php 
                $get_candidate = "SELECT * FROM candidate WHERE candidate_id=$cand_id ";
                $res_candidate = mysqli_query($connection,$get_candidate);
                while($row_candidate= mysqli_fetch_assoc($res_candidate)){
                    ?>
                    console.log(radioValue);
            <?php    }
                
            ?>
                
                
                //return confirm(radioValue);
            }
          
        });
        
    }); 
</script>
       <?php }
    
        }

    /**/
    ?>
<input class='btn btn--radius-2 btn--blue'  type="submit" value ='submit' name='elect' id='vote' >

</form>

</div>
</div>
</div>




 <?php }
 ?>
   

</body>
</html>
