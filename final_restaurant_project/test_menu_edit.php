<?php include 'header.php'; ?>

<section class="menu-edit-test">
    <div class="wrap">
        <h1>🧪 Menu Item Edit Functionality Test</h1>
        <p>Test the complete menu item management system including add, edit, and delete operations.</p>

        <div class="test-overview">
            <h2>📋 Available Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3>📊 View All Items</h3>
                    <p>Browse all menu items in a comprehensive table with images, prices, and restaurant information.</p>
                    <a href="/final_restaurant_project/admin/menu.php" class="test-btn">View Menu Items</a>
                </div>

                <div class="feature-card">
                    <h3>➕ Add New Items</h3>
                    <p>Create new menu items with images, descriptions, and pricing.</p>
                    <a href="/final_restaurant_project/admin/add_food.php" class="test-btn">Add Menu Item</a>
                </div>

                <div class="feature-card">
                    <h3>✏️ Edit Existing Items</h3>
                    <p>Modify item details, update images, and change pricing.</p>
                    <p><small>First add an item, then edit it from the menu list.</small></p>
                </div>

                <div class="feature-card">
                    <h3>🗑️ Delete Items</h3>
                    <p>Remove menu items with confirmation and automatic image cleanup.</p>
                    <p><small>Delete button available in the menu items table.</small></p>
                </div>
            </div>
        </div>

        <div class="test-instructions">
            <h2>🧪 How to Test</h2>
            <div class="instruction-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Add a Menu Item</h4>
                        <p>Go to "Add Menu Item" and create a new item with image, name, description, and price.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>View in List</h4>
                        <p>Check "Menu Items" to see your new item in the comprehensive table.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Edit the Item</h4>
                        <p>Click "Edit" on your item and modify details or upload a new image.</p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Delete Test Item</h4>
                        <p>Use the "Delete" button to remove the test item (with confirmation).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="database-status">
            <h2>🗃️ Database Status</h2>
            <?php
            $restaurant_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant"))['count'];
            $menu_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item"))['count'];
            $order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
            ?>
            <div class="stats-display">
                <div class="stat-item">
                    <span class="stat-number"><?php echo $restaurant_count; ?></span>
                    <span class="stat-label">Restaurants</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $menu_count; ?></span>
                    <span class="stat-label">Menu Items</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $order_count; ?></span>
                    <span class="stat-label">Orders</span>
                </div>
            </div>
        </div>

        <div class="admin-navigation">
            <h2>⚙️ Quick Admin Access</h2>
            <div class="admin-links">
                <a href="/final_restaurant_project/admin/menu.php" class="admin-btn primary">📊 Manage Menu Items</a>
                <a href="/final_restaurant_project/admin/restaurant.php" class="admin-btn secondary">🏪 Manage Restaurants</a>
                <a href="/final_restaurant_project/admin/index.php" class="admin-btn info">📈 Admin Dashboard</a>
            </div>
        </div>
    </div>
</section>

<style>
.menu-edit-test { padding: 40px 0; }
.menu-edit-test h1 { text-align: center; margin-bottom: 10px; color: #333; }
.menu-edit-test > .wrap > p { text-align: center; color: #666; margin-bottom: 50px; }

.test-overview { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.test-overview h2 { text-align: center; margin-bottom: 30px; color: #333; }

.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.feature-card { background: #f8f9fa; border-radius: 10px; padding: 20px; text-align: center; border: 1px solid #dee2e6; transition: transform 0.3s ease; }
.feature-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.feature-card h3 { margin: 0 0 15px 0; color: #495057; }
.feature-card p { margin: 0 0 15px 0; color: #6c757d; font-size: 0.9em; }
.test-btn { display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 500; transition: all 0.3s ease; }
.test-btn:hover { background: linear-gradient(135deg, #667eea, #764ba2); transform: translateY(-2px); }

.test-instructions { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.test-instructions h2 { text-align: center; margin-bottom: 30px; color: #333; }

.instruction-steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
.step { display: flex; gap: 15px; align-items: flex-start; }
.step-number { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; flex-shrink: 0; }
.step-content h4 { margin: 0 0 8px 0; color: #495057; }
.step-content p { margin: 0; color: #6c757d; font-size: 0.9em; }

.database-status { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.database-status h2 { text-align: center; margin-bottom: 30px; color: #333; }

.stats-display { display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; }
.stat-item { text-align: center; }
.stat-number { display: block; font-size: 3em; font-weight: bold; color: #667eea; line-height: 1; }
.stat-label { display: block; color: #666; font-size: 0.9em; margin-top: 5px; }

.admin-navigation { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.admin-navigation h2 { text-align: center; margin-bottom: 30px; color: #333; }

.admin-links { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
.admin-btn { display: inline-block; padding: 15px 25px; text-decoration: none; border-radius: 25px; font-weight: 500; font-size: 16px; transition: all 0.3s ease; text-align: center; min-width: 180px; }
.admin-btn.primary { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; }
.admin-btn.primary:hover { background: linear-gradient(135deg, #667eea, #764ba2); transform: translateY(-2px); }
.admin-btn.secondary { background: linear-gradient(135deg, rgba(40,167,69,0.8), rgba(32,201,151,0.8)); color: #fff; }
.admin-btn.secondary:hover { background: linear-gradient(135deg, #28a745, #20c997); transform: translateY(-2px); }
.admin-btn.info { background: linear-gradient(135deg, rgba(23,162,184,0.8), rgba(102,16,242,0.8)); color: #fff; }
.admin-btn.info:hover { background: linear-gradient(135deg, #17a2b8, #6610f2); transform: translateY(-2px); }

@media(max-width:768px) {
    .features-grid { grid-template-columns: 1fr; }
    .instruction-steps { grid-template-columns: 1fr; }
    .stats-display { gap: 30px; }
    .admin-links { flex-direction: column; align-items: center; }
    .admin-btn { min-width: 250px; }
}
</style>

<?php include 'footer.php'; ?>


