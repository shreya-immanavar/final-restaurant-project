<?php
session_start();
include 'db.php';
include 'header.php';

// Check if order_id is provided
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if($order_id <= 0) {
    header("Location: index.php");
    exit;
}

// Fetch order details with customer info
$stmt = mysqli_prepare($conn, "SELECT o.*, c.name as customer_name, c.email, r.name as restaurant_name
                               FROM orders o
                               JOIN customers c ON o.customer_id = c.customer_id
                               JOIN restaurant r ON o.restaurant_id = r.restaurant_id
                               WHERE o.order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$order_result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($order_result);
mysqli_stmt_close($stmt);

if(!$order) {
    echo "<div class='wrap container'><h2>Order not found.</h2><a href='/final_restaurant_project/index.php' class='btn'>Back to Home</a></div>";
    include 'footer.php';
    exit;
}

// Check if user owns this order or is admin
if(!isset($_SESSION['customer_id']) || ($_SESSION['customer_id'] != $order['customer_id'] && !isset($_SESSION['admin_id']))) {
    header("Location: auth/login.php");
    exit;
}

// Fetch order items
$stmt = mysqli_prepare($conn, "SELECT oi.*, mi.item_name, mi.price, mi.image
                               FROM order_item oi
                               JOIN menu_item mi ON oi.item_id = mi.item_id
                               WHERE oi.order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$order_items_result = mysqli_stmt_get_result($stmt);
$order_items = array();
while($item = mysqli_fetch_assoc($order_items_result)) {
    $order_items[] = $item;
}
mysqli_stmt_close($stmt);

// Fetch payment info
$stmt = mysqli_prepare($conn, "SELECT * FROM payment WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$payment_result = mysqli_stmt_get_result($stmt);
$payment = mysqli_fetch_assoc($payment_result);
mysqli_stmt_close($stmt);

// Fetch delivery info
$stmt = mysqli_prepare($conn, "SELECT * FROM delivery WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$delivery_result = mysqli_stmt_get_result($stmt);
$delivery = mysqli_fetch_assoc($delivery_result);
mysqli_stmt_close($stmt);
?>

<section class="order-confirmation">
    <div class="wrap">
        <div class="confirmation-header">
            <div class="success-icon">✓</div>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your order. We'll start preparing your delicious food soon.</p>
        </div>

        <div class="order-details-container">
            <!-- Order Info -->
            <div class="order-info">
                <h2>Order Details</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Order ID:</strong>
                        <span>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Order Date:</strong>
                        <span><?php echo date('F j, Y \a\t g:i A', strtotime($order['order_date'])); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Restaurant:</strong>
                        <span><?php echo htmlspecialchars($order['restaurant_name']); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Status:</strong>
                        <span class="status-<?php echo strtolower($order['status']); ?>"><?php echo $order['status']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="customer-info">
                <h2>Customer Information</h2>
                <div class="info-list">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="order-items">
                <h2>Order Items</h2>
                <div class="items-list">
                    <?php foreach($order_items as $item): ?>
                    <div class="order-item">
                        <div class="item-image">
                            <?php if($item['image'] && file_exists('assets/images/menu/' . $item['image'])): ?>
                                <img src="assets/images/menu/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                            <?php else: ?>
                                <div class="image-placeholder-small">
                                    <span><?php echo htmlspecialchars(substr($item['item_name'], 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="item-details">
                            <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                            <p>Quantity: <?php echo $item['qty']; ?> × ₹<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                        <div class="item-total">
                            ₹<?php echo number_format($item['price'] * $item['qty'], 2); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-total">
                    <div class="total-row">
                        <strong>Total Amount: ₹<?php echo number_format($order['total_amount'], 2); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Payment & Delivery Info -->
            <?php if($payment || $delivery): ?>
            <div class="additional-info">
                <?php if($payment): ?>
                <div class="payment-info">
                    <h3>Payment Information</h3>
                    <p><strong>Method:</strong> <?php echo htmlspecialchars($payment['method']); ?></p>
                    <p><strong>Status:</strong> <span class="status-<?php echo strtolower($payment['status']); ?>"><?php echo $payment['status']; ?></span></p>
                </div>
                <?php endif; ?>

                <?php if($delivery): ?>
                <div class="delivery-info">
                    <h3>Delivery Information</h3>
                    <p><strong>Status:</strong> <span class="status-<?php echo strtolower($delivery['status']); ?>"><?php echo $delivery['status']; ?></span></p>
                    <?php if($delivery['delivered_at']): ?>
                    <p><strong>Delivered At:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($delivery['delivered_at'])); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>



        <div class="order-actions">
            <a href="/final_restaurant_project/index.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
