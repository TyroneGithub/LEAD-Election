<?php
// Load the database configuration file
include 'connection.php';

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $username   = mysqli_real_escape_string($connection, $line[0]); 
                $name  =  mysqli_real_escape_string($connection, $line[1]);  
                $section  =mysqli_real_escape_string($connection, $line[2]); 
                $password = mysqli_real_escape_string($connection, $line[3]); 
                $hash = password_hash($password,PASSWORD_DEFAULT);
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT * FROM users WHERE username = '$username'  ";
                $prevResult = mysqli_query($connection, $prevQuery) or die (mysqli_error($connection));
                $countResult = mysqli_num_rows($prevResult);
                if($countResult>=1){
                    // Update member data in the database
                    $get_section = "SELECT * FROM section WHERE section_name = '$section' ";
                    $result_section = mysqli_query($connection,$get_section);
                    while ($row_section = mysqli_fetch_assoc($result_section)){
                        $sec_id = $row_section['section_id'];

                        $update_users = "UPDATE users SET username='$username', name='$name',
                        section='$sec_id', password='$hash', role='student' WHERE username='$username' ";
                        $result_update = mysqli_query($connection,$update_users);
                        
                        if($result_update){
                            $stringupdate= '&update=success';
                        }
                        else{
                            $stingupdate= '&update=fail';
                        }
                    }



                }else{
                    // Insert member data in the database
                    $get_section = "SELECT * FROM section WHERE section_name = '$section' ";
                    $result_section = mysqli_query($connection,$get_section);
                    while ($row_section = mysqli_fetch_assoc($result_section)){
                        $sec_id = $row_section['section_id'];

                        $insert_users = "INSERT INTO users (username,name,section,password,role)
                        VALUES ('$username','$name','$sec_id','$hash','student') ";
                        $result_insert = mysqli_query($connection,$insert_users);
                        
                        if($insert_users){
                            $stringins = '&insert=success';
                        }
                        else{
                            $stingins = '&insert=fail';
                        }
                    }
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location:students.php".$qstring.$stringins."&add=true");