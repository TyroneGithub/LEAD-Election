<?php
include 'connection.php';
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
if ($curr_date>$end_date){
	$update = "UPDATE schedule SET election = 0 WHERE sched_id=1 ";
	mysqli_query($connection,$update);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/login/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="css/login/css/main.css">
    <link rel="stylesheet" type="text/css" href="css/login/custom.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
  
    <title>LEAD Election System</title>
</head>
<body>
    	
 <!-- login container !-->
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<img src="images/vectorlsqc.png" id='logo-lsqc'/>
				<div class="login100-pic js-tilt" data-tilt>
                    <!img src="images/logo.jpg" alt="IMG">
                    <H2> LEAD Election System</H2>
                   
				</div>

				<form class="login100-form validate-form" method="POST" action='login.php?method=login'>
				
                <!-- username !-->

					<div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="user" placeholder="Username"
                        autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
                            <i class="fas fa-user"></i>
						</span>
					</div>
	
                <!-- password !-->

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
                	
                <!-- login button !-->
                    
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
            	
                <!-- forgot password !-->

					<div class="text-center p-t-12">
					
					
					</div>

					<div class="text-center p-t-136">
						
					</div>
				</form>
				<p id="creator">Created by: Tyrone Sta. Maria | LSQC Batch 2019</p>
			</div>
		</div>
	</div>
	
</body>
</html>