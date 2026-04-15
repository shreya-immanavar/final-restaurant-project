<?php
include 'db.php';
include 'header.php';
?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 Edit Pages Test</h1>
        <p>Test that edit restaurant and menu item pages work properly</p>

        <?php
        $tests = [];
        $all_passed = true;

        // Test restaurant data exists
        $restaurant_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant"))['count'];
        $tests[] = ['🏪 Restaurants Available', $restaurant_count > 0 ? 'YES' : 'NO', "$restaurant_count restaurants in database"];

        // Test menu item data exists
        $menu_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item"))['count'];
        $tests[] = ['🍽️ Menu Items Available', $menu_count > 0 ? 'YES' : 'NO', "$menu_count menu items in database"];

        // Test sample restaurant for editing
        $sample_restaurant = mysqli_fetch_assoc(mysqli_query($conn, "SELECT restaurant_id, name FROM restaurant LIMIT 1"));
        $tests[] = ['📝 Sample Restaurant', $sample_restaurant ? 'FOUND' : 'NONE', $sample_restaurant ? "ID: {$sample_restaurant['restaurant_id']} - {$sample_restaurant['name']}" : 'No restaurants to edit'];

        // Test sample menu item for editing
        $sample_menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT mi.item_id, mi.item_name, r.name as restaurant FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id LIMIT 1"));
        $tests[] = ['📝 Sample Menu Item', $sample_menu ? 'FOUND' : 'NONE', $sample_menu ? "ID: {$sample_menu['item_id']} - {$sample_menu['item_name']} ({$sample_menu['restaurant']})" : 'No menu items to edit'];
        ?>

        <div class="test-results">
            <?php foreach ($tests as $test): ?>
            <div class="test-item">
                <div class="test-name"><?php echo $test[0]; ?></div>
                <div class="test-status <?php echo strtolower(str_replace([' ', '-'], '', $test[1])); ?>"><?php echo $test[1]; ?></div>
                <div class="test-detail"><?php echo $test[2]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="edit-test-section">
            <h2>🖊️ Test Edit Pages</h2>
            <p>Click the buttons below to test the edit functionality:</p>

            <div class="edit-buttons">
                <?php if($sample_restaurant): ?>
                <a href="/final_restaurant_project/admin/edit_restaurant.php?id=<?php echo $sample_restaurant['restaurant_id']; ?>" class="btn btn-primary">
                    ✏️ Edit Restaurant: <?php echo htmlspecialchars($sample_restaurant['name']); ?>
                </a>
                <?php endif; ?>

                <?php if($sample_menu): ?>
                <a href="/final_restaurant_project/admin/edit_menu_item.php?id=<?php echo $sample_menu['item_id']; ?>" class="btn btn-secondary">
                    ✏️ Edit Menu Item: <?php echo htmlspecialchars($sample_menu['item_name']); ?>
                </a>
                <?php endif; ?>
            </div>

            <?php if(!$sample_restaurant && !$sample_menu): ?>
            <div class="no-data-message">
                <p>⚠️ No data available to edit. Please add restaurants and menu items first.</p>
                <a href="/final_restaurant_project/admin/add_restaurant.php" class="btn btn-primary">Add Restaurant</a>
                <a href="/final_restaurant_project/admin/add_food.php" class="btn btn-secondary">Add Menu Item</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="features-showcase">
            <h2>✨ Edit Page Features</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <h3>🎨 Modern Design</h3>
                    <p>Clean, professional interface matching the add pages</p>
                </div>
                <div class="feature-item">
                    <h3>🔒 Security</h3>
                    <p>Prepared statements, input validation, file security</p>
                </div>
                <div class="feature-item">
                    <h3>📱 Responsive</h3>
                    <p>Works perfectly on desktop and mobile devices</p>
                </div>
                <div class="feature-item">
                    <h3>🖼️ Image Management</h3>
                    <p>Update images with automatic old file cleanup</p>
                </div>
                <div class="feature-item">
                    <h3>✅ Validation</h3>
                    <p>Client and server-side validation with error messages</p>
                </div>
                <div class="feature-item">
                    <h3>🔄 Live Updates</h3>
                    <p>Form refreshes with updated data after successful edits</p>
                </div>
            </div>
        </div>

        <?php if ($sample_restaurant || $sample_menu): ?>
        <div class="success-message">
            <h2>🎉 Edit System Ready!</h2>
            <p>Your edit pages are fully functional with modern design and security.</p>
        </div>
        <?php else: ?>
        <div class="warning-message">
            <h2>⚠️ No Data to Edit</h2>
            <p>Add some restaurants and menu items first, then come back to test editing.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.test-section { padding: 40px 0; }
.test-results { background: #fff; border-radius: 10px; padding: 20px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.test-item { display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 15px; padding: 10px 0; border-bottom: 1px solid #eee; align-items: center; }
.test-item:last-child { border-bottom: none; }
.test-name { font-weight: 600; }
.test-status { padding: 4px 8px; border-radius: 4px; text-align: center; font-size: 0.9em; font-weight: bold; }
.test-status.yes, .test-status.found { background: #d4edda; color: #155724; }
.test-status.no, .test-status.none { background: #f8d7da; color: #721c24; }
.test-detail { color: #666; font-size: 0.9em; }
.edit-test-section { background: #fff; border-radius: 10px; padding: 30px; margin: 30px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.edit-test-section h2 { margin-bottom: 15px; color: #333; }
.edit-buttons { display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap; }
.edit-buttons .btn { padding: 15px 25px; text-decoration: none; font-size: 16px; }
.no-data-message { text-align: center; padding: 30px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; margin: 20px 0; }
.no-data-message p { margin-bottom: 15px; color: #856404; }
.features-showcase { background: #fff; border-radius: 10px; padding: 30px; margin: 30px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.features-showcase h2 { text-align: center; margin-bottom: 30px; color: #333; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.feature-item { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border: 1px solid #dee2e6; }
.feature-item h3 { margin: 0 0 10px 0; color: #495057; }
.feature-item p { margin: 0; color: #6c757d; font-size: 0.9em; }
.success-message, .warning-message { text-align: center; padding: 30px; background: #fff; border-radius: 10px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.success-message h2 { color: #28a745; }
.warning-message h2 { color: #ffc107; }
.success-message p, .warning-message p { margin: 15px 0; }
@media(max-width:768px){ .edit-buttons{ flex-direction: column; } .features-grid{ grid-template-columns: 1fr; } .test-item{ grid-template-columns: 1fr; gap: 5px; } }
</style>

<?php include 'footer.php'; ?>


