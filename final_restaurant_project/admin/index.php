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
<link rel="stylesheet" href="../assets/css/style.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    .admin-dashboard {max-width:1200px;margin:0 auto;padding:20px;}
    .dashboard-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;}
    .dashboard-header h1{font-size:2.5em;font-weight:700;color:#2d3748;margin:0;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:30px;}
    .stat-card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 15px rgba(0,0,0,0.1);text-align:center;}
    .stat-number{font-size:2em;font-weight:600;color:#333;margin-bottom:5px;}
    .stat-label{color:#666;}
    .recent-orders{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 15px rgba(0,0,0,0.1);}
    .recent-orders h2{margin-bottom:20px;}
    .orders-table{width:100%;border-collapse:collapse;}
    .orders-table th,.orders-table td{padding:10px;text-align:left;border-bottom:1px solid #eee;}
    .orders-table th{background:#f8f9fa;}
    .status-badge{padding:3px 6px;border-radius:3px;font-size:0.7em;text-transform:uppercase;}
    .status-placed{background:#ffc107;color:#fff;}
    .status-completed{background:#28a745;color:#fff;}
    .admin-nav{background:#f8f9fa;padding:15px;border-radius:8px;margin-bottom:20px;display:flex;gap:8px;flex-wrap:wrap;}
    .admin-nav a{background:linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));color:#fff;text-decoration:none;padding:10px 18px;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.1);box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .admin-nav a::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.2),transparent);transition:left 0.5s ease;}
    .admin-nav a:hover{background:linear-gradient(135deg, #667eea, #764ba2);transform:translateY(-2px);box-shadow:0 6px 20px rgba(102,126,234,0.3);border-color:rgba(255,255,255,0.3);}
    .admin-nav a:hover::before{left:100%;}
    .back-to-site-btn{display:inline-block;padding:12px 24px;background:linear-gradient(135deg, #28a745, #20c997);color:#fff !important;text-decoration:none !important;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.2);box-shadow:0 4px 15px rgba(40,167,69,0.3);margin-top:10px;}
    .back-to-site-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);transition:left 0.5s ease;}
    .back-to-site-btn:hover{background:linear-gradient(135deg, #20c997, #28a745);color:#fff !important;transform:translateY(-3px);box-shadow:0 8px 25px rgba(40,167,69,0.4);border-color:rgba(255,255,255,0.4);}
    
    /* Updated Logout Button CSS */
    .logout-btn {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, #dc3545, #e55d42);
        color: #fff !important;
        text-decoration: none !important;
        border-radius: 25px;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 15px rgba(220,53,69,0.3);
        text-align: center;
        margin-top:10px;
    }
    .logout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }
    .logout-btn:hover {
        background: linear-gradient(135deg, #e55d42, #dc3545);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(220,53,69,0.4);
        border-color: rgba(255,255,255,0.4);
        color:#fff !important;
    }
    .logout-btn:hover::before { left:100%; }
    .logout-btn:focus { outline:none; box-shadow:0 0 0 4px rgba(220,53,69,0.3); }
    .logout-btn:active { transform:translateY(-1px); box-shadow:0 4px 15px rgba(220,53,69,0.2); }

    /* Responsive */
    @media(max-width:768px){.dashboard-header{flex-direction:column;align-items:flex-start;gap:10px;}.stats-grid{grid-template-columns:1fr;}}
</style>
</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="?logout=1" class="logout-btn">Logout</a>
            <a href="../index.php" class="back-to-site-btn">← Back to Main Site</a>
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
