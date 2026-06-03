<?php
include 'auth_check.php';
include '../db.php';

// Unified Update logic for both Order and Delivery
if(isset($_GET['order_id']) && isset($_GET['status'])) {
    $order_id = (int)$_GET['order_id'];
    $new_status = mysqli_real_escape_string($conn, $_GET['status']);

    if($new_status === 'Placed' || $new_status === 'Processing') {
        $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE order_id=?");
        mysqli_stmt_bind_param($stmt, "si", $new_status, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } 
    else if ($new_status === 'Shipped') {
        $order_stat = 'Processing'; // Keep order as Processing while shipping
        $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE order_id=?");
        mysqli_stmt_bind_param($stmt, "si", $order_stat, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        $del_stat = 'Out for Delivery';
        $stmt2 = mysqli_prepare($conn, "UPDATE delivery SET status=? WHERE order_id=?");
        mysqli_stmt_bind_param($stmt2, "si", $del_stat, $order_id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }
    else if ($new_status === 'Delivered' || $new_status === 'Completed') {
        $order_stat = 'Completed';
        $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE order_id=?");
        mysqli_stmt_bind_param($stmt, "si", $order_stat, $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        $del_stat = 'Delivered';
        $stmt2 = mysqli_prepare($conn, "UPDATE delivery SET status=?, delivered_at=NOW() WHERE order_id=?");
        mysqli_stmt_bind_param($stmt2, "si", $del_stat, $order_id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }

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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">

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
                            <form method="GET" action="manage_orders.php" style="display:flex; gap:8px; align-items:center;">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <select name="status" class="status-select" style="padding:6px 12px; border-radius:4px; background:var(--color-surface); color:var(--color-text); border:1px solid var(--color-border); appearance:auto; background-image:none; margin-right:5px;">
                                    <option value="Placed" <?php if($order['status'] == 'Placed') echo 'selected'; ?>>Placed / Pending</option>
                                    <option value="Processing" <?php if($order['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                    <option value="Shipped" <?php if($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Delivered" <?php if($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Completed" <?php if($order['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <button type="submit" class="btn-small btn-update">Update</button>
                            </form>
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
