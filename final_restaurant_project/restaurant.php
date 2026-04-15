<?php include 'header.php';

// Get restaurant ID from URL
$restaurant_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($restaurant_id <= 0) {
    header("Location: restaurants.php");
    exit;
}

// Fetch restaurant details
$restaurant_query = mysqli_query($conn, "SELECT * FROM restaurant WHERE restaurant_id = $restaurant_id");
$restaurant = mysqli_fetch_assoc($restaurant_query);

if(!$restaurant) {
    header("Location: restaurants.php");
    exit;
}

// Fetch menu items for this restaurant
$menu_items = mysqli_query($conn, "SELECT * FROM menu_item WHERE restaurant_id = $restaurant_id ORDER BY item_name");
?>

<section class="restaurant-detail">
    <div class="wrap">
        <!-- Restaurant Header -->
        <div class="restaurant-header">
            <div class="restaurant-image">
                <?php if($restaurant['image'] && file_exists('assets/images/restaurants/' . $restaurant['image'])): ?>
                    <img src="assets/images/restaurants/<?php echo htmlspecialchars($restaurant['image']); ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
                <?php else: ?>
                    <div class="image-placeholder-large">
                        <span><?php echo htmlspecialchars(substr($restaurant['name'], 0, 1)); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="restaurant-info">
                <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                <p class="location">📍 <?php echo htmlspecialchars($restaurant['location']); ?></p>
                <a href="restaurants.php" class="btn btn-secondary">← Back to Restaurants</a>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="menu-section">
            <h2>Menu</h2>

            <?php if(mysqli_num_rows($menu_items) > 0): ?>
                <div class="menu-grid">
                    <?php while($item = mysqli_fetch_assoc($menu_items)): ?>
                    <div class="menu-item-card">
                        <div class="menu-item-image">
                            <?php if($item['image'] && file_exists('assets/images/menu/' . $item['image'])): ?>
                                <img src="assets/images/menu/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                            <?php else: ?>
                                <div class="image-placeholder">
                                    <span><?php echo htmlspecialchars(substr($item['item_name'], 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="menu-item-info">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <p class="price">₹<?php echo number_format($item['price'], 2); ?></p>
                            <a href="cart.php?add=<?php echo $item['item_id']; ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-items">
                    <p>No menu items available for this restaurant at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
