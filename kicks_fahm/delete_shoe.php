<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    die();
}

$id = $_GET['id'];
$sql = "DELETE FROM shoes WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: shoes.php");
    die();
} else {
    echo "Failed to delete shoe!";
}
?>