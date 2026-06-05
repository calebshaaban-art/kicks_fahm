<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}

if(isset($_GET['add'])){
    $id = $_GET['add'];
    $sql = "SELECT * FROM shoes WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $shoe = mysqli_fetch_assoc($result);
    
    if($shoe){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $shoe['name'],
                'price' => $shoe['price'],
                'quantity' => 1
            ];
        }
    }
    header("Location: cart.php");
    die();
}

if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    die();
}

$total = 0;
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $item){
        $total += $item['price'] * $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kicks Fahm - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: url('/kicks-fahm/images/background.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh;" class="text-white">
<div style="background: rgba(0,0,0,0.85); min-height: 100vh;">
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary px-4">
        <span class="navbar-brand">👟 Kicks Fahm</span>
        <div>
            <a href="shoes.php" class="btn btn-outline-light btn-sm me-2">Browse Shoes</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container mt-4">
        <h2 class="mb-4">🛒 Your Cart</h2>
        <?php if(empty($_SESSION['cart'])): ?>
            <div class="alert alert-info">Your cart is empty! <a href="shoes.php">Browse shoes</a></div>
        <?php else: ?>
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Shoe</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td>KSh <?php echo $item['price']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>KSh <?php echo $item['price'] * $item['quantity']; ?></td>
                        <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong>KSh <?php echo $total; ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>