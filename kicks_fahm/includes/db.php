<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kicks_fahm";

$conn = mysqli_connect($host, $user, $password, $dbname);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>