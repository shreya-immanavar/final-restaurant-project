<?php
include 'auth_check.php';
include '../db.php';

// Update order status
if(isset($_GET['order_id']) && isset($_GET['status'])) {
    $order_id = (int)$_GET['order_id'];
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE order_id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: manage_orders.php");
    exit;
}

// Update delivery status
if(isset($_GET['delivery_id']) && isset($_GET['delivery_status'])) {
    $delivery_id = (int)$_GET['delivery_id'];
    $delivery_status = mysqli_real_escape_string($conn, $_GET['delivery_status']);

    if($delivery_status === 'Delivered') {
        // Set delivered_at timestamp
        $stmt = mysqli_prepare($conn, "UPDATE delivery SET status=?, delivered_at=NOW() WHERE delivery_id=?");
        mysqli_stmt_bind_param($stmt, "si", $delivery_status, $delivery_id);
    } else {
        // Update status without timestamp
        $stmt = mysqli_prepare($conn, "UPDATE delivery SET status=? WHERE delivery_id=?");
        mysqli_stmt_bind_param($stmt, "si", $delivery_status, $delivery_id);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: manage_orders.php");
    exit;
}

// Fetch all orders with customer and restaurant info
$orders_query = "SELECT o.*, c.name AS customer_name, c.email, r.name AS restaurant_name,
                        d.status AS delivery_status, d.delivery_id, d.delivered_at
                 FROM orders o
                 JOIN customers c ON o.customer_id = c.customer_id
                 JOIN restaurant r ON o.restaurant_id = r.restaurant_id
                 LEFT JOIN delivery d ON o.order_id = d.order_id
                 ORDER BY o.order_date DESC";
$orders = mysqli_query($conn, $orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container{max-width:1200px;margin:0 auto;padding:20px}
        .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
        .admin-nav{background:#f8f9fa;padding:15px;border-radius:8px;margin-bottom:20px;display:flex;gap:8px;flex-wrap:wrap}
        .admin-nav a{background:linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));color:#fff;text-decoration:none;padding:10px 18px;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.1);box-shadow:0 2px 8px rgba(0,0,0,0.1)}
        .admin-nav a:hover{background:linear-gradient(135deg, #667eea, #764ba2);transform:translateY(-2px);box-shadow:0 6px 20px rgba(102,126,234,0.3);border-color:rgba(255,255,255,0.3)}
        .back-to-site-btn{display:inline-block;padding:12px 24px;background:linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));color:#fff !important;text-decoration:none !important;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.2);box-shadow:0 4px 15px rgba(40,167,69,0.3);margin-top:20px}
        .back-to-site-btn:hover{background:linear-gradient(135deg, #28a745, #20c997);color:#fff !important;text-decoration:none !important;transform:translateY(-3px);box-shadow:0 8px 25px rgba(40,167,69,0.4);border-color:rgba(255,255,255,0.4)}
        .orders-table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
        .orders-table th,.orders-table td{padding:12px;text-align:left;border-bottom:1px solid #eee}
        .orders-table th{background:#f8f9fa;font-weight:600}
        .status-badge{padding:4px 8px;border-radius:4px;font-size:0.8em;text-transform:uppercase}

        /* Order Status */
        .status-placed{background:#ffc107;color:#fff}
        .status-processing{background:#17a2b8;color:#fff}
        .status-completed{background:#28a745;color:#fff}
        .status-pending{background:#6c757d;color:#fff}

        /* Delivery Status */
        .status-pending-delivery{background:#6c757d;color:#fff}
        .status-out-for-delivery{background:#28a745;color:#fff}
        .status-delivered{background:#20c997;color:#fff}

        .action-links{display:flex;gap:10px}
        .btn-small{padding:4px 8px;text-decoration:none !important;border-radius:4px;font-size:0.8em}
        .btn-update{background:#007bff;color:#fff !important}
        .btn-update:hover{color:#fff !important;text-decoration:none !important}
        .btn-deliver{background:#28a745;color:#fff !important}
        .btn-deliver:hover{color:#fff !important;text-decoration:none !important}
        .order-items{max-height:100px;overflow-y:auto;font-size:0.9em}
        .order-item{display:flex;justify-content:space-between;margin-bottom:5px}
    </style>
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1>Manage Orders</h1>
        <a href="../index.php" class="back-to-site-btn">← Back to Main Site</a>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Orders</a>
        <a href="restaurant.php">Restaurants</a>
        <a href="menu.php">Menu Items</a>
        <a href="add_restaurant.php">Add Restaurant</a>
        <a href="add_food.php">Add Menu Item</a>
    </nav>

    <div class="orders-table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Restaurant</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Delivery</th>
                    <th>Delivered At</th>
                    <th>Order Date</th>
                    <th>Items</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = mysqli_fetch_assoc($orders)) {
                    $order_id = $order['order_id'];

                    // Fetch order items
                    $stmt = mysqli_prepare($conn, "SELECT oi.*, mi.item_name, mi.price
                                                  FROM order_item oi
                                                  JOIN menu_item mi ON oi.item_id = mi.item_id
                                                  WHERE oi.order_id = ?");
                    mysqli_stmt_bind_param($stmt, "i", $order_id);
                    mysqli_stmt_execute($stmt);
                    $items_result = mysqli_stmt_get_result($stmt);
                    $items = array();
                    while($item = mysqli_fetch_assoc($items_result)) {
                        $items[] = $item;
                    }
                    mysqli_stmt_close($stmt);

                    // Prepare delivery class for color
                    $delivery_status = $order['delivery_status'] ?? 'Pending Delivery';
                    $class_name = strtolower(str_replace(' ', '-', $delivery_status));
                ?>
                <tr>
                    <td>#<?php echo str_pad($order_id, 6, '0', STR_PAD_LEFT); ?></td>
                    <td>
                        <div><?php echo htmlspecialchars($order['customer_name']); ?></div>
                        <small><?php echo htmlspecialchars($order['email']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($order['restaurant_name']); ?></td>
                    <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><span class="status-badge status-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span></td>
                    <td><span class="status-badge status-<?php echo $class_name; ?>"><?php echo $delivery_status; ?></span></td>
                    <td><?php echo !empty($order['delivered_at']) ? date('M j, Y g:i A', strtotime($order['delivered_at'])) : '-'; ?></td>
                    <td><?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></td>
                    <td>
                        <div class="order-items">
                            <?php foreach($items as $item): ?>
                            <div class="order-item">
                                <span><?php echo htmlspecialchars($item['item_name']); ?> × <?php echo $item['qty']; ?></span>
                                <span>₹<?php echo number_format($item['price'] * $item['qty'], 2); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td>
                        <div class="action-links">
                            <?php if($order['status'] != 'Completed'): ?>
                                <a href="?order_id=<?php echo $order_id; ?>&status=Processing" class="btn-small btn-update"
                                   onclick="return confirm('Mark as Processing?')">Process</a>
                                <a href="?order_id=<?php echo $order_id; ?>&status=Completed" class="btn-small btn-update"
                                   onclick="return confirm('Mark as Completed?')">Complete</a>
                            <?php endif; ?>

                            <?php if(isset($order['delivery_id']) && $order['delivery_status'] != 'Delivered'): ?>
                                <a href="?delivery_id=<?php echo $order['delivery_id']; ?>&delivery_status=Out for Delivery" class="btn-small btn-deliver"
                                   onclick="return confirm('Mark as Out for Delivery?')">Out for Delivery</a>
                                <a href="?delivery_id=<?php echo $order['delivery_id']; ?>&delivery_status=Delivered" class="btn-small btn-deliver"
                                   onclick="return confirm('Mark as Delivered?')">Delivered</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
