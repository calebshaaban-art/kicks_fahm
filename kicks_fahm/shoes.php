<?php
session_start();
require_once 'includes/db.php';

$sql = "SELECT * FROM shoes";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kicks Fahm - Browse Shoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: url('/kicks-fahm/images/background.jpg') no-repeat center center fixed; background-size: cover; color: white; font-family: 'Arial', sans-serif; }
        /* Navbar */
        .navbar { background: #0a0a0a; border-bottom: 2px solid #ff6600; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .navbar-brand { font-size: 24px; font-weight: 900; color: #ff6600; letter-spacing: 3px; }
        .nav-links a { color: #aaa; text-decoration: none; margin-left: 20px; font-size: 14px; transition: color 0.3s; }
        .nav-links a:hover { color: #ff6600; }
        .nav-btn { background: #ff6600; color: white; border: none; padding: 8px 20px; border-radius: 5px; font-size: 13px; font-weight: bold; text-decoration: none; margin-left: 10px; }
        .nav-btn:hover { background: #cc5200; color: white; }

        /* Hero */
        .hero { background: linear-gradient(135deg, #0a0a0a, #1a1a1a); padding: 60px 30px; text-align: center; border-bottom: 1px solid #222; }
        .hero h1 { font-size: 60px; font-weight: 900; color: white; letter-spacing: 5px; }
        .hero h1 span { color: #ff6600; }
        .hero p { color: #888; font-size: 16px; margin-top: 10px; }

        /* Filter Bar */
        .filter-bar { background: #111; padding: 15px 30px; display: flex; gap: 10px; align-items: center; border-bottom: 1px solid #222; flex-wrap: wrap; }
        .filter-btn { background: #1a1a1a; border: 1px solid #333; color: #aaa; padding: 8px 20px; border-radius: 25px; cursor: pointer; font-size: 13px; transition: all 0.3s; }
        .filter-btn:hover, .filter-btn.active { background: #ff6600; border-color: #ff6600; color: white; }
        .filter-label { color: #888; font-size: 13px; margin-right: 5px; }

        /* Products Grid */
        .products-section { padding: 40px 30px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        
        /* Shoe Card */
        .shoe-card { background: #111; border: 1px solid #222; border-radius: 12px; overflow: hidden; transition: all 0.3s; position: relative; cursor: pointer; }
        .shoe-card:hover { transform: translateY(-8px); border-color: #ff6600; box-shadow: 0 20px 40px rgba(255,102,0,0.2); }
        .shoe-img { width: 100%; height: 280px; object-fit: cover; background: #1a1a1a; display: flex; align-items: center; justify-content: center; font-size: 80px; }
        .shoe-img img { width: 100%; height: 280px; object-fit: cover; }
        .new-badge { position: absolute; top: 15px; left: 15px; background: #ff6600; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; letter-spacing: 1px; }
        .shoe-info { padding: 20px; }
        .shoe-brand { color: #ff6600; font-size: 11px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; }
        .shoe-name { font-size: 18px; font-weight: bold; color: white; margin: 5px 0; }
        .shoe-details { color: #888; font-size: 13px; margin: 5px 0; }
        .shoe-price { font-size: 22px; font-weight: 900; color: white; margin: 15px 0 10px; }
        .shoe-price span { color: #ff6600; }
        .btn-cart { background: #ff6600; color: white; border: none; padding: 10px; width: 100%; border-radius: 8px; font-weight: bold; font-size: 14px; transition: background 0.3s; text-decoration: none; display: block; text-align: center; }
        .btn-cart:hover { background: #cc5200; color: white; }
        .admin-btns { display: flex; gap: 8px; margin-top: 8px; }
        .btn-edit { background: #333; color: #ff6600; border: 1px solid #ff6600; padding: 7px; flex: 1; border-radius: 8px; font-size: 13px; text-align: center; text-decoration: none; transition: all 0.3s; }
        .btn-edit:hover { background: #ff6600; color: white; }
        .btn-delete { background: #333; color: #ff4444; border: 1px solid #ff4444; padding: 7px; flex: 1; border-radius: 8px; font-size: 13px; text-align: center; text-decoration: none; transition: all 0.3s; }
        .btn-delete:hover { background: #ff4444; color: white; }

        /* Empty state */
        .empty-state { text-align: center; padding: 80px; color: #555; }
        .empty-state h3 { font-size: 30px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-brand">👟 KICKS FAHM</div>
        <div class="nav-links">
            <?php if(isset($_SESSION['username'])): ?>
                <span style="color:#888; font-size:13px;">Hey, <?php echo $_SESSION['username']; ?>!</span>
                <a href="dashboard.php">Dashboard</a>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="add_shoe.php" class="nav-btn">+ ADD SHOE</a>
                <?php endif; ?>
                <a href="cart.php" class="nav-btn" style="background:#222; border:1px solid #ff6600; color:#ff6600;">🛒 CART</a>
                <a href="logout.php" style="color:#ff4444; margin-left:15px; font-size:13px;">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-btn">LOGIN</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Hero -->
    <div class="hero">
        <h1>FRESH <span>KICKS</span></h1>
        <p>The latest drops. The hottest styles. Only at Kicks Fahm. 🔥</p>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <span class="filter-label">BRAND:</span>
        <button class="filter-btn active" onclick="filterShoes('all')">All</button>
        <button class="filter-btn" onclick="filterShoes('Nike')">Nike</button>
        <button class="filter-btn" onclick="filterShoes('Adidas')">Adidas</button>
        <button class="filter-btn" onclick="filterShoes('Jordan')">Jordan</button>
        <button class="filter-btn" onclick="filterShoes('Puma')">Puma</button>
        <button class="filter-btn" onclick="filterShoes('Vans')">Vans</button>
        <button class="filter-btn" onclick="filterShoes('Converse')">Converse</button>
        <button class="filter-btn" onclick="filterShoes('New Balance')">New Balance</button>
    </div>

    <!-- Products -->
    <div class="products-section">
        <?php
        $count = mysqli_num_rows($result);
        if($count == 0):
        ?>
        <div class="empty-state">
            <h3>👟 No Shoes Yet</h3>
            <p>Check back soon for fresh drops!</p>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="add_shoe.php" class="nav-btn" style="display:inline-block; margin-top:20px; padding:12px 30px;">+ ADD FIRST SHOE</a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="products-grid" id="shoesGrid">
            <?php while($shoe = mysqli_fetch_assoc($result)): ?>
            <div class="shoe-card" data-brand="<?php echo $shoe['brand']; ?>">
                <span class="new-badge">NEW DROP</span>
                <?php if($shoe['cover_image']): ?>
                    <div class="shoe-img"><img src="images/<?php echo $shoe['cover_image']; ?>" alt="<?php echo $shoe['name']; ?>"></div>
                <?php else: ?>
                    <div class="shoe-img">👟</div>
                <?php endif; ?>
                <div class="shoe-info">
                    <div class="shoe-brand"><?php echo $shoe['brand']; ?></div>
                    <div class="shoe-name"><?php echo $shoe['name']; ?></div>
                    <div class="shoe-details">Size: <?php echo $shoe['size']; ?> &nbsp;|&nbsp; Color: <?php echo $shoe['color']; ?></div>
                    <div class="shoe-price">KSh <span><?php echo number_format($shoe['price'], 2); ?></span></div>
                    <a href="cart.php?add=<?php echo $shoe['id']; ?>" class="btn-cart">🛒 ADD TO CART</a>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <div class="admin-btns">
                        <a href="edit_shoe.php?id=<?php echo $shoe['id']; ?>" class="btn-edit">✏️ Edit</a>
                        <a href="delete_shoe.php?id=<?php echo $shoe['id']; ?>" class="btn-delete">🗑️ Delete</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function filterShoes(brand){
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filter cards
        document.querySelectorAll('.shoe-card').forEach(card => {
            if(brand === 'all' || card.dataset.brand === brand){
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    </script>
</body>
</html>