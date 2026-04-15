<?php
session_start();
include 'db.php';

// Initialize cart if not exists
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add item to cart
if(isset($_GET['add'])) {
    $item_id = (int)$_GET['add'];
    if($item_id > 0) {
        if(isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]++;
        } else {
            $_SESSION['cart'][$item_id] = 1;
        }
    }
    header("Location: cart.php");
    exit;
}

// Remove item from cart
if(isset($_GET['remove'])) {
    $item_id = (int)$_GET['remove'];
    if(isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]--;
        if($_SESSION['cart'][$item_id] <= 0) {
            unset($_SESSION['cart'][$item_id]);
        }
    }
    header("Location: cart.php");
    exit;
}

// Update quantity
if(isset($_POST['update_cart'])) {
    foreach($_POST['quantity'] as $item_id => $qty) {
        $qty = (int)$qty;
        if($qty <= 0) {
            unset($_SESSION['cart'][$item_id]);
        } else {
            $_SESSION['cart'][$item_id] = $qty;
        }
    }
    header("Location: cart.php");
    exit;
}

// Clear cart
if(isset($_GET['clear'])) {
    $_SESSION['cart'] = array();
    header("Location: cart.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<section class="cart-section">
    <div class="wrap">
        <h1>Your Shopping Cart</h1>

        <?php if(!empty($_SESSION['cart'])): ?>
            <div class="cart-actions">
                <a href="/final_restaurant_project/cart.php?clear=1" class="btn btn-secondary" onclick="return confirm('Clear all items from cart?')">Clear Cart</a>
            </div>

            <form method="post" class="cart-form">
                <div class="cart-table">
                    <div class="cart-header">
                        <div>Item</div>
                        <div>Price</div>
                        <div>Quantity</div>
                        <div>Subtotal</div>
                        <div>Action</div>
                    </div>

                    <?php
                    $total = 0;
                    foreach($_SESSION['cart'] as $item_id => $qty):
                        $stmt = mysqli_prepare($conn, "SELECT * FROM menu_item WHERE item_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $item_id);
                        mysqli_stmt_execute($stmt);
                        $item_result = mysqli_stmt_get_result($stmt);
                        $item = mysqli_fetch_assoc($item_result);
                        mysqli_stmt_close($stmt);

                        if($item):
                            $subtotal = $item['price'] * $qty;
                            $total += $subtotal;
                    ?>
                    <div class="cart-row">
                        <div class="item-info">
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
                            </div>
                        </div>
                        <div class="price">₹<?php echo number_format($item['price'], 2); ?></div>
                        <div class="quantity">
                            <input type="number" name="quantity[<?php echo $item_id; ?>]" value="<?php echo $qty; ?>" min="1" max="99">
                        </div>
                        <div class="subtotal">₹<?php echo number_format($subtotal, 2); ?></div>
                        <div class="action">
                            <a href="/final_restaurant_project/cart.php?remove=<?php echo $item_id; ?>" class="btn-remove" onclick="return confirm('Remove this item?')">Remove</a>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>

                    <div class="cart-total">
                        <div class="total-row">
                            <strong>Total: ₹<?php echo number_format($total, 2); ?></strong>
                        </div>
                    </div>
                </div>

                <div class="cart-buttons">
                    <a href="/final_restaurant_project/restaurants.php" class="btn btn-secondary">Continue Shopping</a>
        
                    <a href="/final_restaurant_project/checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </form>

        <?php else: ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Add some delicious food from our restaurants!</p>
                <a href="/final_restaurant_project/restaurants.php" class="btn btn-primary">Browse Restaurants</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
