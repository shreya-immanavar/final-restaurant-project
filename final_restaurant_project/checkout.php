<?php
session_start();
include 'db.php';
include 'header.php';

// Check if user is logged in
if(!isset($_SESSION['customer_id'])){
    header("Location: auth/login.php");
    exit;
}

// Check if cart is empty
if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit;
}

// Handle order placement
if(isset($_POST['place_order'])){
    $customer_id = $_SESSION['customer_id'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $delivery_address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $special_instructions = isset($_POST['special_instructions']) ? mysqli_real_escape_string($conn, $_POST['special_instructions']) : '';

    // Update customer's phone and address
    $stmt = mysqli_prepare($conn, "UPDATE customers SET phone=?, address=? WHERE customer_id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $phone, $delivery_address, $customer_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $total = 0;
    $restaurant_ids = array();

    // Calculate total and collect restaurant IDs
    foreach($_SESSION['cart'] as $item_id => $qty) {
        $stmt = mysqli_prepare($conn, "SELECT mi.*, r.restaurant_id FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id WHERE mi.item_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $item = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if($item) {
            $total += $item['price'] * $qty;
            $restaurant_ids[] = $item['restaurant_id'];
        }
    }

    $restaurant_id = $restaurant_ids[0]; // assuming single restaurant orders

    // Insert order
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, restaurant_id, total_amount, status) VALUES (?, ?, ?, ?)");
    $status = 'Placed';
    mysqli_stmt_bind_param($stmt, "iids", $customer_id, $restaurant_id, $total, $status);
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // Insert order items
    foreach($_SESSION['cart'] as $item_id => $qty) {
        $stmt = mysqli_prepare($conn, "SELECT price FROM menu_item WHERE item_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $item = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if($item) {
            $stmt = mysqli_prepare($conn, "INSERT INTO order_item (order_id, item_id, qty, price) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item_id, $qty, $item['price']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Insert payment record
    $stmt = mysqli_prepare($conn, "INSERT INTO payment (order_id, amount, method, status) VALUES (?, ?, ?, ?)");
    $payment_status = 'Paid';
    mysqli_stmt_bind_param($stmt, "idss", $order_id, $total, $payment_method, $payment_status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Insert delivery record
    $stmt = mysqli_prepare($conn, "INSERT INTO delivery (order_id, status) VALUES (?, ?)");
    $delivery_status = 'Preparing';
    mysqli_stmt_bind_param($stmt, "is", $order_id, $delivery_status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Clear cart
    $_SESSION['cart'] = array();

    // Redirect to order confirmation
    header("Location: order_confirmation.php?order_id=" . $order_id);
    exit;
}

// Prepare order summary for display
$order_items = array();
$total = 0;
foreach($_SESSION['cart'] as $item_id => $qty) {
    $stmt = mysqli_prepare($conn, "SELECT mi.*, r.name as restaurant_name FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id WHERE mi.item_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if($item) {
        $subtotal = $item['price'] * $qty;
        $total += $subtotal;
        $order_items[] = array(
            'item' => $item,
            'quantity' => $qty,
            'subtotal' => $subtotal
        );
    }
}
?>

<section class="checkout-section">
    <div class="wrap">
        <h1>Checkout</h1>

        <div class="checkout-container">
            <!-- Order Summary -->
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="order-items">
                    <?php foreach($order_items as $order_item): ?>
                    <div class="order-item">
                        <div class="item-info">
                            <h4><?php echo htmlspecialchars($order_item['item']['item_name']); ?></h4>
                            <p><?php echo htmlspecialchars($order_item['item']['restaurant_name']); ?></p>
                        </div>
                        <div class="item-quantity">x<?php echo $order_item['quantity']; ?></div>
                        <div class="item-price">₹<?php echo number_format($order_item['subtotal'], 2); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-total">
                    <strong>Total: ₹<?php echo number_format($total, 2); ?></strong>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="checkout-form">
                <h2>Delivery Details</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label for="delivery_address">Delivery Address *</label>
                        <textarea name="delivery_address" id="delivery_address" required placeholder="Enter your full delivery address"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method *</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="Cash">Cash on Delivery</option>
                            <option value="Card">Card (Coming Soon)</option>
                            <option value="UPI">UPI (Coming Soon)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="special_instructions">Special Instructions</label>
                        <textarea name="special_instructions" id="special_instructions" placeholder="Any special delivery instructions..."></textarea>
                    </div>

                    <div class="checkout-actions">
                        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                        <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
