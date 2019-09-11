<?php
$connect_servername="localhost";
$connect_username="root";
$connect_password="";
$connect_dbname="lead";

$connection = mysqli_connect ($connect_servername, $connect_username, $connect_password,
$connect_dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>