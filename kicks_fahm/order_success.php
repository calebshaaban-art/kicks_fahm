<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: url('/kicks-fahm/images/background.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh;" class="text-white">
<div style="background: rgba(0,0,0,0.85); min-height: 100vh;">
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary px-4">
        <span class="navbar-brand">👟 Kicks Fahm</span>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card text-white p-5" style="background: rgba(0,0,0,0.7);">
                    <h1>🎉</h1>
                    <h2>Order Placed Successfully!</h2>
                    <p class="mt-3">Thank you for shopping at Kicks Fahm! Your shoes are on their way 👟</p>
                    <a href="shoes.php" class="btn btn-warning mt-3">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>