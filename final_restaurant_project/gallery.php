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
                                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
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
                        <a href="/final_restaurant_project/admin/add_restaurant.php" class="btn btn-primary">Add First Restaurant</a>
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
                                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
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
                        <a href="/final_restaurant_project/admin/add_food.php" class="btn btn-primary">Add First Menu Item</a>
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

<style>
/* Gallery Section - Premium Design */
.gallery-section { 
    padding: 60px 0; 
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.gallery-section h1 { 
    text-align: center; 
    margin-bottom: 15px; 
    color: #2d3748; 
    font-size: 2.5em;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.05);
}

.gallery-section > .wrap > p { 
    text-align: center; 
    color: #718096; 
    margin-bottom: 60px; 
    font-size: 1.1em;
}

/* Gallery Categories - Better Separation */
.gallery-category { 
    margin-bottom: 80px; 
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    border: none;
}

.gallery-category h2 { 
    color: #2d3748; 
    margin-bottom: 30px; 
    padding-bottom: 15px; 
    border-bottom: none;
    font-size: 1.8em;
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.gallery-category h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
}

/* Image Grid - Better Spacing */
.image-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
    gap: 30px; 
    margin-top: 30px;
}

/* Image Cards - Premium Design */
.image-card { 
    background: #fff; 
    border-radius: 15px; 
    overflow: hidden; 
    box-shadow: 0 5px 20px rgba(0,0,0,0.08); 
    transition: all 0.3s ease;
    border: none;
}

.image-card:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.image-container { 
    height: 220px; 
    overflow: hidden; 
    position: relative; 
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
}

.image-container img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: transform 0.3s ease;
}

.image-card:hover .image-container img {
    transform: scale(1.1);
}

.image-placeholder { 
    width: 100%; 
    height: 100%; 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    justify-content: center; 
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
    color: #94a3b8; 
}

.image-placeholder span { 
    font-size: 3.5em; 
    margin-bottom: 10px; 
    opacity: 0.6;
}

.image-placeholder p {
    font-size: 0.9em;
    color: #94a3b8;
}

/* Image Info - Clean Design */
.image-info { 
    padding: 25px; 
}

.image-info h3 { 
    margin: 0 0 10px 0; 
    color: #2d3748; 
    font-size: 1.3em; 
    font-weight: 600;
}

.image-info p { 
    margin: 0 0 12px 0; 
    color: #718096; 
    font-size: 0.95em;
}

.price-tag { 
    display: inline-block; 
    background: linear-gradient(135deg, #28a745, #20c997); 
    color: #fff; 
    padding: 6px 12px; 
    border-radius: 20px; 
    font-weight: 600; 
    margin-bottom: 12px; 
    font-size: 0.95em;
    box-shadow: 0 2px 8px rgba(40,167,69,0.3);
}

.description { 
    color: #64748b; 
    font-size: 0.9em; 
    line-height: 1.6; 
    margin-bottom: 15px; 
}

/* Image Meta - No Ugly Border */
.image-meta { 
    margin-top: 20px; 
    padding-top: 15px; 
    border-top: none;
    background: linear-gradient(135deg, #f8f9fa 0%, #f1f5f9 100%);
    padding: 10px 15px;
    border-radius: 8px;
}

.image-meta small { 
    color: #94a3b8; 
    font-size: 0.85em;
}

/* No Images Section */
.no-images { 
    grid-column: 1 / -1; 
    text-align: center; 
    padding: 80px 20px; 
    background: linear-gradient(135deg, #f8f9fa 0%, #f1f5f9 100%); 
    border-radius: 15px; 
    border: none;
}

.no-images p { 
    color: #64748b; 
    margin-bottom: 25px; 
    font-size: 1.1em;
}

/* Stats Section - Premium Design */
.stats-section { 
    background: #fff; 
    border-radius: 20px; 
    padding: 50px 40px; 
    margin: 60px 0; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
    border: none;
}

.stats-section h2 { 
    text-align: center; 
    margin-bottom: 40px; 
    color: #2d3748; 
    font-size: 1.8em;
    font-weight: 600;
}

.stats-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
    gap: 30px; 
}

.stat-card { 
    text-align: center; 
    padding: 30px 20px; 
    background: linear-gradient(135deg, #f8f9fa 0%, #f1f5f9 100%); 
    border-radius: 15px; 
    border: none;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.stat-number { 
    font-size: 2.8em; 
    font-weight: 700; 
    color: #667eea; 
    margin-bottom: 8px; 
}

.stat-label { 
    color: #64748b; 
    font-size: 0.95em; 
    font-weight: 500;
}

/* Admin Actions - Clean Design */
.admin-actions { 
    background: #fff; 
    border-radius: 20px; 
    padding: 50px 40px; 
    margin: 60px 0; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
    text-align: center; 
    border: none;
}

.admin-actions h2 { 
    margin-bottom: 30px; 
    color: #2d3748; 
    font-size: 1.8em;
    font-weight: 600;
}

.action-buttons { 
    display: flex; 
    gap: 20px; 
    justify-content: center; 
    flex-wrap: wrap; 
}

.action-buttons .btn { 
    padding: 14px 28px; 
    text-decoration: none !important; 
    border-radius: 25px; 
    font-weight: 500; 
    font-size: 14px;
    letter-spacing: 0.5px;
}

.btn-info { 
    background: linear-gradient(135deg, #17a2b8, #6610f2); 
    color: #fff !important; 
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 4px 15px rgba(23,162,184,0.3);
}

.btn-info:hover { 
    background: linear-gradient(135deg, #138496, #5a0fc8); 
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23,162,184,0.4);
    color: #fff !important;
    text-decoration: none !important;
}

/* Responsive Design */
@media(max-width:768px) {
    .gallery-section {
        padding: 40px 0;
    }
    
    .gallery-section h1 {
        font-size: 2em;
    }
    
    .gallery-category {
        padding: 30px 20px;
        margin-bottom: 50px;
    }
    
    .image-grid { 
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
        gap: 20px;
    }
    
    .action-buttons { 
        flex-direction: column; 
        align-items: center; 
        gap: 15px;
    }
    
    .action-buttons .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .stats-grid { 
        grid-template-columns: 1fr; 
        gap: 20px;
    }
    
    .stats-section,
    .admin-actions {
        padding: 30px 20px;
        margin: 40px 0;
    }
}
</style>

<?php include 'footer.php'; ?>
