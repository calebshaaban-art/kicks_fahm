<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}

$total_shoes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM shoes"))['total'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$recent_orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kicks Fahm - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Arial', sans-serif; background: #0a0a0a; color: white; }
        .sidebar { width: 250px; height: 100vh; background: #111; position: fixed; left: 0; top: 0; padding: 20px 0; border-right: 2px solid #ff6600; }
        .sidebar-brand { text-align: center; padding: 20px; border-bottom: 1px solid #333; margin-bottom: 20px; }
        .sidebar-brand h2 { color: #ff6600; font-weight: bold; margin: 0; }
        .sidebar-brand p { color: #888; font-size: 12px; margin: 0; }
        .sidebar-menu a { display: block; padding: 12px 25px; color: #aaa; text-decoration: none; transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar-menu a:hover { color: #ff6600; background: #1a1a1a; border-left: 3px solid #ff6600; }
        .sidebar-menu a.active { color: #ff6600; background: #1a1a1a; border-left: 3px solid #ff6600; }
        .main-content { margin-left: 250px; padding: 30px; }
        .stat-card { background: #111; border: 1px solid #222; border-radius: 10px; padding: 25px; text-align: center; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); border-color: #ff6600; }
        .stat-number { font-size: 48px; font-weight: bold; color: #ff6600; }
        .stat-label { color: #888; font-size: 14px; margin-top: 5px; }
        .stat-icon { font-size: 30px; margin-bottom: 10px; }
        .section-title { color: #ff6600; font-size: 18px; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .quick-action-btn { background: #ff6600; border: none; color: white; padding: 12px 20px; border-radius: 8px; width: 100%; margin-bottom: 10px; font-weight: bold; transition: background 0.3s; }
        .quick-action-btn:hover { background: #cc5200; color: white; }
        .quick-action-btn.secondary { background: #222; border: 1px solid #ff6600; color: #ff6600; }
        .quick-action-btn.secondary:hover { background: #ff6600; color: white; }
        table { width: 100%; }
        .table-dark { background: #111; }
        .table-dark th { background: #1a1a1a; color: #ff6600; border-color: #333; }
        .table-dark td { border-color: #222; color: #ccc; }
        .badge-completed { background: #28a745; padding: 4px 10px; border-radius: 20px; font-size: 11px; }
        .badge-pending { background: #ff6600; padding: 4px 10px; border-radius: 20px; font-size: 11px; }
        .welcome-banner { background: linear-gradient(135deg, #ff6600, #cc3300); border-radius: 10px; padding: 25px; margin-bottom: 30px; }
        .welcome-banner h3 { margin: 0; font-size: 24px; }
        .welcome-banner p { margin: 5px 0 0; opacity: 0.8; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>👟 KICKS</h2>
            <p>FAHM</p>
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="active">📊 Dashboard</a>
            <a href="shoes.php">👟 Browse Shoes</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href="add_shoe.php">➕ Add Shoe</a>
            <?php endif; ?>
            <a href="cart.php">🛒 Cart</a>
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h3>Welcome back, <?php echo $_SESSION['username']; ?>! 🔥</h3>
            <p>Here's what's dropping at Kicks Fahm today</p>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="stat-icon">👟</div>
                    <div class="stat-number"><?php echo $total_shoes; ?></div>
                    <div class="stat-label">TOTAL SHOES</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number"><?php echo $total_users; ?></div>
                    <div class="stat-label">TOTAL CUSTOMERS</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-number"><?php echo $total_orders; ?></div>
                    <div class="stat-label">TOTAL ORDERS</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Orders -->
            <div class="col-md-8">
                <div class="section-title">🧾 Recent Orders</div>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td>KSh <?php echo $order['total_amount']; ?></td>
                            <td><span class="badge-<?php echo $order['status']; ?>"><?php echo strtoupper($order['status']); ?></span></td>
                            <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="section-title">⚡ Quick Actions</div>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="add_shoe.php"><button class="quick-action-btn">➕ Add New Shoe</button></a>
                <?php endif; ?>
                <a href="shoes.php"><button class="quick-action-btn secondary">👟 View All Shoes</button></a>
                <a href="cart.php"><button class="quick-action-btn secondary">🛒 View Cart</button></a>
            </div>
        </div>
    </div>
</body>
</html>