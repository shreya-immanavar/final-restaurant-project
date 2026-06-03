<?php include 'header.php'; ?>

<section class="gallery-section">
    <div class="wrap">
        <h1>🍽️ FoodieHub Gallery</h1>
        <p>Showcase of uploaded restaurant and menu images</p>

        <?php
        // Get restaurants with images
        $restaurants_query = "SELECT * FROM restaurant WHERE image IS NOT NULL AND image != '' ORDER BY restaurant_id DESC";
        $restaurants = mysqli_query($conn, $restaurants_query);

        // Get menu items with images
        $menu_items_query = "SELECT mi.*, r.name as restaurant_name FROM menu_item mi
                           JOIN restaurant r ON mi.restaurant_id = r.restaurant_id
                           WHERE mi.image IS NOT NULL AND mi.image != ''
                           ORDER BY mi.item_id DESC";
        $menu_items = mysqli_query($conn, $menu_items_query);
        ?>

        <!-- Restaurant Gallery -->
        <div class="gallery-category">
            <h2>🏪 Restaurants</h2>
            <div class="image-grid">
                <?php if(mysqli_num_rows($restaurants) > 0): ?>
                    <?php while($restaurant = mysqli_fetch_assoc($restaurants)): ?>
                        <div class="image-card">
                            <div class="image-container">
                                <?php
                                $image_path = 'assets/images/restaurants/' . $restaurant['image'];
                                if(file_exists($image_path)): ?>
                                    <img src="<?php echo BASE_URL . $image_path; ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        <span>🏪</span>
                                        <p>Image not found</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="image-info">
                                <h3><?php echo htmlspecialchars($restaurant['name']); ?></h3>
                                <p><?php echo htmlspecialchars($restaurant['location']); ?></p>
                                <div class="image-meta">
                                    <small>Restaurant ID: <?php echo $restaurant['restaurant_id']; ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-images">
                        <p>No restaurant images uploaded yet.</p>
                        <a href="<?php echo BASE_URL; ?>admin/add_restaurant.php" class="btn btn-primary">Add First Restaurant</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Menu Items Gallery -->
        <div class="gallery-category">
            <h2>🍽️ Menu Items</h2>
            <div class="image-grid">
                <?php if(mysqli_num_rows($menu_items) > 0): ?>
                    <?php while($item = mysqli_fetch_assoc($menu_items)): ?>
                        <div class="image-card">
                            <div class="image-container">
                                <?php
                                $image_path = 'assets/images/menu/' . $item['image'];
                                if(file_exists($image_path)): ?>
                                    <img src="<?php echo BASE_URL . $image_path; ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        <span>🍽️</span>
                                        <p>Image not found</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="image-info">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <p><?php echo htmlspecialchars($item['restaurant_name']); ?></p>
                                <div class="price-tag">₹<?php echo number_format($item['price'], 2); ?></div>
                                <?php if($item['description']): ?>
                                    <p class="description"><?php echo htmlspecialchars(substr($item['description'], 0, 100)); ?><?php echo strlen($item['description']) > 100 ? '...' : ''; ?></p>
                                <?php endif; ?>
                                <div class="image-meta">
                                    <small>Item ID: <?php echo $item['item_id']; ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-images">
                        <p>No menu item images uploaded yet.</p>
                        <a href="<?php echo BASE_URL; ?>admin/add_food.php" class="btn btn-primary">Add First Menu Item</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upload Statistics -->
        <div class="stats-section">
            <h2>📊 Upload Statistics</h2>
            <div class="stats-grid">
                <?php
                $restaurant_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant WHERE image IS NOT NULL AND image != ''"))['count'];
                $menu_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item WHERE image IS NOT NULL AND image != ''"))['count'];
                $total_restaurants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant"))['count'];
                $total_menu_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item"))['count'];
                ?>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $restaurant_count; ?>/<?php echo $total_restaurants; ?></div>
                    <div class="stat-label">Restaurants with Images</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $menu_count; ?>/<?php echo $total_menu_items; ?></div>
                    <div class="stat-label">Menu Items with Images</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $restaurant_count + $menu_count; ?></div>
                    <div class="stat-label">Total Images Uploaded</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
