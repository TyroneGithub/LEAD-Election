<?php
include 'connection.php';
session_start();
if (empty($_SESSION['username'])){
    header('location:index.php'); 
}
else if ($_SESSION['type']=='student'){
    header('location:main.php?type=student');
}
date_default_timezone_set("Asia/Manila");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/admin/general-settings.css">
    <link rel="stylesheet" href="css/admin/edit-overlay.css">
    <script src="js/overlay.js"></script>
    <script src="js/status-overlay.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



    <title>Settings</title>
</head>
<body >

    <?php
    include 'header-admin.php';
    include 'sidebar-admin.php';
    ?>

<div class='main-wrap'>
<div class='box'>


    <div id="overlay" style="display:none;"></div>
    
    <?php 

    if (isset($_GET['add']) or isset($_GET['change'])  ){

   
?>
    <body onload="editSuccess_on();">

    </body>
  <?php  }
    ?>
    <div id='status-overlay'><div id='status-box'>
        <h2>
        <img src='images/green-check.png'/>
        <br>
        <?php
            if (isset($_GET['change'])){
                echo "Password Changed!";
            }
            else{
                echo "Added Successfully!";
            }
        
        ?>
        
       
        </h2>
        <button onclick='edit_off();'>Close</button>
        </div></div>



    <?php
    $get_date = "SELECT * FROM schedule WHERE sched_id=1";
    $result_date = mysqli_query($connection,$get_date);
    $count_date = mysqli_num_rows($result_date);
    while ($row_date = mysqli_fetch_assoc($result_date)){
        $start_date = $row_date['start_date'];
        $end_date = $row_date['end_date'];
        $election = $row_date['election'];
        $drafting = $row_date['drafting'];
    }
        if (empty($_GET['page'])){
            $_GET['page']=="position";
            header('location:settings.php?page=position');
        }
        // POSITION SETTINGS 
        else if ($_GET['page']=='position'){
            ?>

        <h2>Position</h2>
        
        <?php
  
  $curr_date = date('Y-m-d');
  
    if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
        echo "<div class='add'><h4 onclick='addStudent();'><i class='fas fa-plus-circle'></i> Add Position</h4></div>";
    }
  
    else{
        echo "<div class='add'><h4 style='cursor:not-allowed'><i class='fas fa-plus-circle'></i> Add Position</h4></div>";
    }


?>

      
        <!--Start table !-->
        <table id='table-hide'>
            <tr>
            <th>Position Name</th>
            <th>Position Code</th>
            <th>Options</th>    
            </tr>
        <?php
        $get_position = "SELECT * FROM position WHERE active =1";
        $res_pos = mysqli_query($connection,$get_position);
        while($row_pos = mysqli_fetch_assoc($res_pos)){
            $pos_id = $row_pos['position_id'];
            $pos_name = $row_pos['pos_name'];
            $pos_code = $row_pos['pos_code'];
            echo "
            <tr>
            <td class='pos-name'>$pos_name</td>
            <td class='pos-code'>$pos_code</td>";

          
                if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
                    echo"
                    <td class='option'> 
                    <a href='edit-settings.php?page=position&pos_id=$pos_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                    <a href='remove-settings.php?remove=true&page=position&pos_id=$pos_id' class='remove' "; ?>
                    onclick="return confirm('Are you sure you want to remove this position? Changes cannot be undone.');">
                    <i class='fas fa-minus-circle'></i>
                     Remove</a></td>
                    </tr>
                <?php
                }
                else{
                    echo"
                    <td class='option'> 
                    <a nohref='edit-settings.php?page=position&pos_id=$pos_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                    <a nohref='remove-settings.php?remove=true&page=position&pos_id=$pos_id' class='remove'>
                    <i class='fas fa-minus-circle'></i>
                    Remove</a></td>
                   </tr> ";
                 }  
            }
                
        
            ?>
        </table>
        <!--End table !-->

        <!--Start Form !-->
        <div class='form' id='form-hide'>
        <div class='form-header'><h2>Add Position</h2></div>
        <form action="add-settings.php?page=position" method="post" autocomplete='off'>
        <label for = 'student-no'>Position Name:</label>
        <input type="text" name="pos_name" id="student-no" required/>
        <br>
        <br>
        <label for = 'name'>Position Code:</label>
        <input type="text" name="pos_code" id="name" required/>
        <br>
        <br>
        <label for = 'section'>Grade Level:</label>
        <select name="level" id="section" required >
        <option value="">Select Grade Level: </option>
    <?php
        for ($i=7; $i<=12; $i++ ){
            echo "<option value='$i' >Grade $i</option>";
        }
    ?>
        </select>
        <br>
        <br>

        <label for = 'winner'>No. of Winners:</label>
        
        <input type="number" name="winner" id="winner" required/>
        <input type="submit" value="Submit" name = 'submit-form'>
        <button class='cancel' onclick='addStudent_off();'>Cancel</button>
        </form>
        </div>
        <!--End Form !-->
          <!--POSITION SETTINGS END !-->
    <?php
        } 
        // PARTY LIST SETTINGS
    else if ($_GET['page']=='partylist'){
?>
       <h2>Party List</h2>
       <div class='add'>
   <?php
   
        if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
            echo "<h4 onclick='addStudent();'><i class='fas fa-plus-circle'></i>Add Party List</h4>";
        }
        else{
            echo "<h4 style='cursor:not-allowed'><i class='fas fa-plus-circle'></i>Add Party List</h4>";
        }
 
   ?>     
        </div>
    
        <!--Start table !-->
        <table id='table-hide'>
            <tr>
            <th>Party List Name</th>
            <th>Party List Code</th>
            <th>Options</th>    
            </tr>
        <?php
        $get_party = "SELECT * FROM party_list WHERE active =1";
        $res_party = mysqli_query($connection,$get_party);
        while($row_party = mysqli_fetch_assoc($res_party)){
            $party_id = $row_party['party_id'];
            $party_name = $row_party['party_name'];
            $party_code = $row_party['party_code'];
            echo "
            <tr>
            <td class='pos-name'>$party_name</td>
            <td class='pos-code'>$party_code</td>";

                if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
                    echo"
                    <td class='option'> 
                    <a href='edit-settings.php?page=partylist&party_id=$party_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                    <a href='remove-settings.php?remove=true&page=partylist&party_id=$party_id' class='remove' ";
                   ?>
                    onclick="return confirm('Are you sure you want to remove this party list? Changes cannot be undone.');">
                    <i class='fas fa-minus-circle'></i>
                    Remove</a></td>
                    </tr>
              
            <?php  
                }
                else{
                    echo"
                    <td class='option'> 
                    <a nohref='edit-settings.php?page=partylist&party_id=$party_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                   <a nohref='remove-settings.php?remove=true&page=partylist&party_id=$party_id' class='remove'>
                   <i class='fas fa-minus-circle'></i>
                   Remove</a></td>
                   </tr> ";
                }
            }
       
        
            ?>
            
        </table>
        <!--End table !-->

        <!--Start Form !-->
        <div class='form' id='form-hide' style="height:350px;">
        <div class='form-header'><h2>Add Party List</h2></div>
        <form action="add-settings.php?page=partylist" method="post" autocomplete='off'>
        <label for = 'student-no'>Party List Name:</label>
        <input type="text" name="party_name" id="student-no" required/>
        <br>
        <br>
        <label for = 'name'>Party List Code:</label>
        <input type="text" name="party_code" id="name" required/>

        <input type="submit" value="Submit" name = 'submit-form'>
        <button class='cancel' onclick='addStudent_off();'>Cancel</button>
        </form>
        </div>
        <!--End Form !-->


         <!--End Party List Settings !-->
<?php }
    // START SECTION SETTINGS
    else if ($_GET['page']=='section'){
?>
 <h2>Section</h2>
 <div class='add'>
 <?php
    
    if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
            echo "<h4 onclick='addStudent();'><i class='fas fa-plus-circle'></i> Add Section</h4>";
        }
        else{
            echo "<h4 style='cursor:not-allowed'><i class='fas fa-plus-circle'></i> Add Section</h4>";
        }
  
   ?>  
</div>

        <!--Start table !-->
        <table id='table-hide' >
            <tr>
            <th style="width:10%">Grade Level</th>
            <th >Section</th>
            <th>Options</th>    
            </tr>
        <?php
        $get_section = "SELECT * FROM section WHERE active =1 
        ORDER BY level ASC";
        $res_section = mysqli_query($connection,$get_section);
        while($row_section = mysqli_fetch_assoc($res_section)){
            $section_id = $row_section['section_id'];
            $section_name = $row_section['section_name'];
            $level = $row_section['level'];
            echo "
            <tr>
            <td class='pos-name'>$level</td>
            <td class='pos-code'>$section_name</td>";
        
                if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
                    echo"
                    <td class='option' > 
                    <a href='edit-settings.php?page=section&section_id=$section_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                   <a href='remove-settings.php?remove=true&page=section&section_id=$section_id' class='remove' ";
                   ?>
                     onclick="return confirm('Are you sure you want to remove this section? Changes cannot be undone.');">
                   <i class='fas fa-minus-circle'></i>
                   Remove</a></td>
                    </tr>
                <?php
                }
                else{
                    echo"
                    <td class='option' > 
                    <a nohref='edit-settings.php?page=section&section_id=$section_id'>
                    <i class='far fa-edit'></i>
                    Edit</a>
                    <a nohref='remove-settings.php?remove=true&page=section&section_id=$section_id' class='remove'>
                    <i class='fas fa-minus-circle'></i>
                    Remove</a></td>
                    </tr> ";
                }
            }
        
            ?>
       
        </table>
        <!--End table !-->

        <!--Start Form !-->
        <div class='form' id='form-hide' style="height:350px;">
        <div class='form-header'><h2>Add Section</h2></div>
        <form action="add-settings.php?page=section" method="post" autocomplete='off'>
        <label for = 'grade-level'>Grade Level:</label>
        <select name="level" id="grade-level">
            <?php
                for ($i=7; $i<=12; $i++){
                    echo "<option value='$i'>$i</option>";
                }
            ?>
        </select>
        <br>
        <br>
        <label for = 'student-no'>Section Name:</label>
        <input type="text" name="section_name" id="student-no" required/>
        <br>
        <br>
     
        <input type="submit" value="Submit" name = 'submit-form'>
        <button class='cancel' onclick='addStudent_off();'>Cancel</button>
        </form>
        </div>
        <!--End Form !-->

<?php        
    }
    else if ($_GET['page']=='election'){
        ?>
        <h2>Election</h2>
        <h3>Schedule</h3>

    <form action="eval-settings.php" method="post">
    <?php
      $curr_date = date('Y-m-d');
      $get_date = "SELECT * FROM schedule WHERE sched_id=1";
      $result_date = mysqli_query($connection,$get_date);
      $count_date = mysqli_num_rows($result_date);
      while ($row_date = mysqli_fetch_assoc($result_date)){
          $start_date = $row_date['start_date'];
          $end_date = $row_date['end_date'];
          $election = $row_date['election'];
          $drafting = $row_date['drafting'];
      }
  
      if ($election==1 or ($curr_date>=$start_date and $curr_date<=$end_date)){
            echo "
            <label for='status'>Drafting Period:</label>
            <select name='drafting' id='status' disabled>
                <option value='0'>Off</option>
                <option value='1'>On</option>
            </select>
           
            <p class='info' >Drafting period is when the administrator can modify information
            of candidates, students, party lists, sections, and positions. Turning this off will
            disable any type of modifications. This will also allow the administrator to turn on 
            the election period. This is only enabled before and after the election dates set. </p>";
        if ($election==1){
            echo"
            <label for='status'>Election Period:</label>
            <select name='election' id='status' >
            <option value='1'>On</option>
            <option value='0'>Off</option>
            </select>
            <p class='info' style='margin-bottom:-10px;'>
            The election period will enable or disable access to the election form 
            during the election period. This will prevent the students to vote outside the 
            school premises.
            </p>
            ";
        }
        else{
            echo"
            <label for='status'>Election Period:</label>
            <select name='election' id='status' >
            <option value='0'>Off</option>
            <option value='1'>On</option>
            </select>
            <p class='info' style='margin-bottom:-10px;'>
            The election period will enable or disable access to the election form 
            during the election period. This will prevent the students to vote outside the 
            school premises.
            </p>
            ";
        }
             
      }
      else{
        
            if($drafting==1){
                echo "
                <label for='status'>Drafting Period:</label>
                <select name='drafting' id='status' >
                    <option value='1'>On</option>
                    <option value='0'>Off</option>
                </select>
                <p class='info' >Drafting period is when the administrator can modify information
                of candidates, students, party lists, sections, and positions. Turning this off will
                disable any type of modifications. This will also allow the administrator to turn on 
                the election period. This is only enabled before and after the election dates set. </p>
                <label for='status'>Election Period:</label>
                <select name='election' id='status' disabled >
                    <option value='0'>Off</option>
                    <option value='1'>On</option>
                </select>

                ";
            }
            else{
                echo "
                <label for='status'>Drafting Period:</label>
                <select name='drafting' id='status' >
                    <option value='0'>Off</option>
                    <option value='1'>On</option>
                </select>
                <p class='info' >Drafting period is when the administrator can modify information
                of candidates, students, party lists, sections, and positions. Turning this off will
                disable any type of modifications. This will also allow the administrator to turn on 
                the election period. This is only enabled before and after the election dates set. </p>
                ";
                echo"
                <label for='status'>Election Period:</label>
                <select name='election' id='status' disabled>
                    <option value='0'>Off</option>
                    <option value='1'>On</option>
                </select>
                <p class='info' style='margin-bottom:-10px;'>
                The election period will enable or disable access to the election form 
                during the election period. This will prevent the students to vote outside the 
                school premises.
                </p>
                ";
            
        }
       
      }
    ?>
        <br>
        <br>
        <label for="startDate">Start Date:</label>
        <input type="text" name="start" class="datepick" id="startDate" autocomplete="off" value="<?php echo $start_date; ?>"/>
        <br>
        <br>
        <label for="endDate">End Date:</label>
        <input type="text" name="end" class="datepick" id="endDate" autocomplete="off"  value="<?php echo $end_date; ?>"/>
        <br>

        <?php
        if($election==1){
            if($curr_date<$start_date){
                echo "
                <label for='poll'>Election Status: <p style='display:inline-block; color:#c23b22; font-weight:bold'>
                Not Set</p></label> 
                <input type='hidden' id='poll'>
                ";
            }
            else if ($curr_date>$end_date){
              echo "
              <label for='poll'>Election Status: <p style='display:inline-block; color:green; font-weight:bold'>
              Done</p></label> 
              <input type='hidden' id='poll'>
              ";
            }
            else{
              echo "
              <label for='poll'>Election Status: <p style='display:inline-block; color:green; font-weight:bold'>Ongoing</p></label> 
              <input type='hidden' id='poll'>
              ";
            }
        
        }
        else{
            echo "
            <label for='poll'>Election Status: <p style='display:inline-block; color:#c23b22; font-weight:bold'>
            Not Set</p></label> 
            <input type='hidden' id='poll'>
            ";
        }
            

       
        ?>
      
        <br>
    <?php
     if ($drafting==1 and ( $curr_date<$start_date or $curr_date>$end_date)){
        ?>
        <a href="reset-election.php?reset=true"  id='reset-election' 
        onclick="return confirm('Are you sure you want to reset the election results? This action cannot be undone.')">
        <i class="fas fa-minus-circle"></i> Reset Results</a>
    <?php
     }
     else{
    ?>
    <a nohref="reset-election.php?reset=true"  id='reset-election'>
    <i class="fas fa-minus-circle"></i> Reset Results</a>
    <?php
     }
    ?>
        



<br>
<script type="text/javascript">
 $( function() {
    $.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
    $( "#startDate" ).datepicker({
        //minDate:0
    });
  } );
  $( function() {
    $.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
    $( "#endDate" ).datepicker({
        //minDate:0
    });
  } );
</script>
<input type="submit" value="Set Schedule" id="submit-date" name="submit-date">
</form>
<br><br><br><br>
<?php


/*
    if ($count_date>=1){
        $curr_date = date('Y-m-d');
 

            if ($curr_date<$start_date){
                echo "<h3 style='color:#c23b22; '> 
                Election will start on $start_date and will end on $end_date</h3>";
            }
            else if ($curr_date>$end_date){
                echo "<h3 style='color:#c23b22'>Election is not set</h3>";
            }
            else{
                echo "<h3 style='color:#c23b22'>Election is set today</h3>";
            }
        
    }
    else {
        echo "<h3 style='color:#c23b22'>Election is not set</h3>";
    }*/
?>

    <?php
    }
    else if($_GET['page']=='admin'){
        $username = $_SESSION['username'];
    $get_id = "SELECT * FROM users WHERE active = 1 AND username = '$username' ";
    $result_id = mysqli_query($connection,$get_id);
    while($row_id=mysqli_fetch_assoc($result_id)){
        $user_id = $row_id['user_id'];
    }
        ?>


  



    <h2>Admin Settings</h2>
    <h3>Change Password</h3>
   
    <?php
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

     
    echo "<div style='color:red'>";
        if(!isset($_SESSION['pass'])){
            $_SESSION['pass']='';
        }
        else{
           
            echo $_SESSION['pass'];
    
           
        }
    echo "</div>";
    ?>
   
    <form action="change-pass.php?user_id=<?php echo $user_id; ?>" method="post" class='password'>
    <label for="old">Old Password:</label>
    <input type="password" name="old" id="old" required>
    <br>
    <br>
    <label for="new">New Password:</label>
  
    <input type="password" name="new" id="new" required>
    <br>
    <br>
    <label for="confirm">Confirm Password:</label>
    <input type="password" name="confirm" id="confirm" required>

    <input type="submit" value="Change Password" name="change-pass"/>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h3>Add Admin</h3>
    <form action="add_admin.php" method="post" autocomplete="off" class="add-admin">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" >
        <br>
        <br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <br>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Submit" name="add-admin">
    </form>
    <?php    

    }
    ?>
</div>
</div>
</body>
</html>