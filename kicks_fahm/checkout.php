<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}

if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    die();
}

$total = 0;
foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * $item['quantity'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $user_id = $user['id'];
    
    $sql = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total', 'completed')";
    
    if(mysqli_query($conn, $sql)){
        $_SESSION['cart'] = [];
        header("Location: order_success.php");
        die();
    } else {
        $error = "Order failed!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kicks Fahm - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: url('/kicks-fahm/images/background.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh;" class="text-white">
<div style="background: rgba(0,0,0,0.85); min-height: 100vh;">
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary px-4">
        <span class="navbar-brand">👟 Kicks Fahm</span>
        <a href="cart.php" class="btn btn-outline-light btn-sm">Back to Cart</a>
    </nav>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-white" style="background: rgba(0,0,0,0.7);">
                    <div class="card-body p-4">
                        <h3 class="mb-4">💳 Checkout</h3>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <h5>Order Summary:</h5>
                        <?php foreach($_SESSION['cart'] as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo $item['name']; ?> x<?php echo $item['quantity']; ?></span>
                                <span>KSh <?php echo $item['price'] * $item['quantity']; ?></span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <strong>KSh <?php echo $total; ?></strong>
                        </div>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="07XXXXXXXX" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control">
                                    <option>M-Pesa</option>
                                    <option>Credit Card</option>
                                    <option>Cash on Delivery</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>