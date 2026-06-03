<?php
include 'auth_check.php';
include '../db.php';

// Get dashboard statistics
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM customers"))['count'];
$total_restaurants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant"))['count'];
$total_menu_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item"))['count'];

$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'Placed'"))['count'];
$completed_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE status = 'Completed'"))['count'];

// Recent orders
$recent_orders = mysqli_query($conn, "SELECT o.*, c.name as customer_name, r.name as restaurant_name
                                      FROM orders o
                                      JOIN customers c ON o.customer_id = c.customer_id
                                      JOIN restaurant r ON o.restaurant_id = r.restaurant_id
                                      ORDER BY o.order_date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - FoodieHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="?logout=1" class="btn btn-danger">Logout</a>
            <a href="../index.php" class="btn btn-primary">← Back to Main Site</a>
        </div>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="restaurant.php">Restaurants</a>
        <a href="menu.php">Menu Items</a>
        <a href="add_restaurant.php">Add Restaurant</a>
        <a href="add_food.php">Add Menu Item</a>
        <a href="reservations.php">Reservations</a>
    </nav>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_orders; ?></div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_customers; ?></div>
            <div class="stat-label">Total Customers</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_restaurants; ?></div>
            <div class="stat-label">Total Restaurants</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_menu_items; ?></div>
            <div class="stat-label">Menu Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $pending_orders; ?></div>
            <div class="stat-label">Pending Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $completed_orders; ?></div>
            <div class="stat-label">Completed Orders</div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="recent-orders">
        <h2>Recent Orders</h2>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Restaurant</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                <tr>
                    <td>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['restaurant_name']); ?></td>
                    <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><span class="status-badge status-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                    <td><?php echo date('M j, g:i A', strtotime($order['order_date'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div style="margin-top:15px">
            <a href="manage_orders.php" class="back-to-site-btn">View All Orders</a>
        </div>
    </div>
</div>

</body>
</html>
