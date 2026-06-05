<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    die();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO shoes (name, brand, size, color, price, stock, description) 
            VALUES ('$name', '$brand', '$size', '$color', '$price', '$stock', '$description')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: shoes.php");
        die();
    } else {
        $error = "Failed to add shoe!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Shoe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: url('/kicks-fahm/images/background.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh;" class="text-white">
<div style="background: rgba(0,0,0,0.85); min-height: 100vh;">
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary px-4">
        <span class="navbar-brand">👟 Kicks Fahm</span>
        <a href="shoes.php" class="btn btn-outline-light btn-sm">Back to Shoes</a>
    </nav>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-white" style="background: rgba(0,0,0,0.7);">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Add New Shoe 👟</h3>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="add_shoe.php">
                            <div class="mb-3">
                                <label class="form-label">Shoe Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <select name="brand" class="form-control" required>
                                    <option value="Nike">Nike</option>
                                    <option value="Adidas">Adidas</option>
                                    <option value="Puma">Puma</option>
                                    <option value="Vans">Vans</option>
                                    <option value="Converse">Converse</option>
                                    <option value="New Balance">New Balance</option>
                                    <option value="Jordan">Jordan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Size (UK)</label>
                                <select name="size" class="form-control" required>
                                    <option value="UK 4">UK 4</option>
                                    <option value="UK 5">UK 5</option>
                                    <option value="UK 6">UK 6</option>
                                    <option value="UK 7">UK 7</option>
                                    <option value="UK 8">UK 8</option>
                                    <option value="UK 9">UK 9</option>
                                    <option value="UK 10">UK 10</option>
                                    <option value="UK 11">UK 11</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="e.g. Black/White" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price (KSh)</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Add Shoe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>