<?php
include '../header.php';

if(!isset($_SESSION['customer_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];

$stmt = mysqli_prepare($conn,
    "SELECT 
        o.order_id,
        r.name AS restaurant_name,
        r.location,
        o.total_amount,

        d.status AS delivery_status,
        d.delivered_at,

        o.order_date
    FROM orders o
    INNER JOIN restaurant r 
        ON r.restaurant_id = o.restaurant_id
    LEFT JOIN delivery d
        ON d.order_id = o.order_id
    WHERE o.customer_id = ?
    ORDER BY o.order_date DESC"
);

mysqli_stmt_bind_param($stmt, "i", $customer_id);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>

<section class="my-reservations">
    <div class="wrap">
        <h1>My Orders</h1>
        <p>View your complete order history including delivery status</p>

        <?php if(mysqli_num_rows($orders) > 0): ?>
            <div class="reservations-list">

                <?php while($order = mysqli_fetch_assoc($orders)): ?>

                <div class="reservation-card">

                    <div class="reservation-header">
                        <h3><?php echo htmlspecialchars($order['restaurant_name']); ?></h3>

                        <span class="status-badge status-<?php echo strtolower($order['delivery_status'] ?? 'pending'); ?>">
                            <?php echo $order['delivery_status'] ? $order['delivery_status'] : "Pending"; ?>
                        </span>
                    </div>

                    <div class="reservation-details">

                        <div class="detail-item">
                            <strong>📍 Restaurant:</strong>
                            <?php echo htmlspecialchars($order['restaurant_name']); ?>
                        </div>

                        <div class="detail-item">
                            <strong>📅 Ordered On:</strong>
                            <?php echo date('F j, Y', strtotime($order['order_date'])); ?>
                        </div>

                        <div class="detail-item">
                            <strong>🕒 Time:</strong>
                            <?php echo date('g:i A', strtotime($order['order_date'])); ?>
                        </div>

                        <div class="detail-item">
                            <strong>💰 Total:</strong> ₹<?php echo number_format($order['total_amount'], 2); ?>
                        </div>

                        <div class="detail-item">
                            <strong>🚚 Delivery Status:</strong>
                            <?php echo $order['delivery_status'] ? $order['delivery_status'] : "Not Updated"; ?>
                        </div>

                        <?php if($order['delivered_at']): ?>
                        <div class="detail-item">
                            <strong>📦 Delivered At:</strong>
                            <?php echo date('F j, Y g:i A', strtotime($order['delivered_at'])); ?>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="reservation-actions">
                        <small>Order ID: #<?php echo str_pad($order['order_id'], 6, "0", STR_PAD_LEFT); ?></small>
                    </div>

                </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <div class="no-reservations">
                <h2>No orders yet</h2>
                <p>You haven't made any orders.</p>
                <a href="/final_restaurant_project/restaurants.php" class="btn btn-primary">Order Now</a>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php include '../footer.php'; ?>
