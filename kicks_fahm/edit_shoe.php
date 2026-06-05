<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    die();
}

$id = $_GET['id'];
$sql = "SELECT * FROM shoes WHERE id=$id";
$result = mysqli_query($conn, $sql);
$shoe = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    
    $sql = "UPDATE shoes SET name='$name', brand='$brand', size='$size', color='$color', 
            price='$price', stock='$stock', description='$description' WHERE id=$id";
    
    if(mysqli_query($conn, $sql)){
        header("Location: shoes.php");
        die();
    } else {
        $error = "Failed to update shoe!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Shoe</title>
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
                        <h3 class="mb-4">Edit Shoe 👟</h3>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Shoe Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $shoe['name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <select name="brand" class="form-control" required>
                                    <option value="Nike" <?php if($shoe['brand']=='Nike') echo 'selected'; ?>>Nike</option>
                                    <option value="Adidas" <?php if($shoe['brand']=='Adidas') echo 'selected'; ?>>Adidas</option>
                                    <option value="Puma" <?php if($shoe['brand']=='Puma') echo 'selected'; ?>>Puma</option>
                                    <option value="Vans" <?php if($shoe['brand']=='Vans') echo 'selected'; ?>>Vans</option>
                                    <option value="Converse" <?php if($shoe['brand']=='Converse') echo 'selected'; ?>>Converse</option>
                                    <option value="New Balance" <?php if($shoe['brand']=='New Balance') echo 'selected'; ?>>New Balance</option>
                                    <option value="Jordan" <?php if($shoe['brand']=='Jordan') echo 'selected'; ?>>Jordan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Size (UK)</label>
                                <select name="size" class="form-control" required>
                                    <option value="UK 4" <?php if($shoe['size']=='UK 4') echo 'selected'; ?>>UK 4</option>
                                    <option value="UK 5" <?php if($shoe['size']=='UK 5') echo 'selected'; ?>>UK 5</option>
                                    <option value="UK 6" <?php if($shoe['size']=='UK 6') echo 'selected'; ?>>UK 6</option>
                                    <option value="UK 7" <?php if($shoe['size']=='UK 7') echo 'selected'; ?>>UK 7</option>
                                    <option value="UK 8" <?php if($shoe['size']=='UK 8') echo 'selected'; ?>>UK 8</option>
                                    <option value="UK 9" <?php if($shoe['size']=='UK 9') echo 'selected'; ?>>UK 9</option>
                                    <option value="UK 10" <?php if($shoe['size']=='UK 10') echo 'selected'; ?>>UK 10</option>
                                    <option value="UK 11" <?php if($shoe['size']=='UK 11') echo 'selected'; ?>>UK 11</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" value="<?php echo $shoe['color']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price (KSh)</label>
                                <input type="number" name="price" class="form-control" value="<?php echo $shoe['price']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo $shoe['stock']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?php echo $shoe['description']; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Update Shoe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>