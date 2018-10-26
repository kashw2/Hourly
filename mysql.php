<?php 

// Create and maintain the connection

$Host = '127.0.0.1:3306';
$Username = 'root';
$Password = '';
$DatabaseName = 'hourly';

$conn = mysqli_connect($Host, $Username, $Password, $DatabaseName);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($conn->connect_error) {

    echo 'MySQL Error: ' . mysqli_connect_error();
    die;

}

?>