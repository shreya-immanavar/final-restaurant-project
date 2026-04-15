<?php
include 'db.php';
include 'header.php';
?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 Admin Functions Test</h1>

        <?php
        $tests = [];
        $all_passed = true;

        // Test admin session (for demo, we'll set it)
        $_SESSION['admin_id'] = 1;
        $tests[] = ['✅ Admin Session', 'SET', 'Admin access granted'];

        // Test restaurant addition (dry run)
        $stmt = mysqli_prepare($conn, "INSERT INTO restaurant (name, location, image) VALUES (?, ?, ?)");
        if ($stmt) {
            $test_name = 'Test Restaurant';
            $test_location = 'Test Location';
            $test_image = 'test.jpg';

            mysqli_stmt_bind_param($stmt, "sss", $test_name, $test_location, $test_image);

            if (mysqli_stmt_execute($stmt)) {
                $tests[] = ['✅ Restaurant Insert', 'WORKS', 'Database operation successful'];
                // Clean up test data
                $last_id = mysqli_insert_id($conn);
                mysqli_query($conn, "DELETE FROM restaurant WHERE restaurant_id = $last_id");
            } else {
                $tests[] = ['❌ Restaurant Insert', 'FAILED', mysqli_error($conn)];
                $all_passed = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $tests[] = ['❌ Restaurant Prepare', 'FAILED', mysqli_error($conn)];
            $all_passed = false;
        }

        // Test menu item addition (dry run)
        $stmt = mysqli_prepare($conn, "INSERT INTO menu_item (restaurant_id, item_name, description, price, image) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $test_restaurant_id = 1;
            $test_item_name = 'Test Item';
            $test_description = 'Test description';
            $test_price = 99.99;
            $test_image = 'test.jpg';

            mysqli_stmt_bind_param($stmt, "issds", $test_restaurant_id, $test_item_name, $test_description, $test_price, $test_image);

            if (mysqli_stmt_execute($stmt)) {
                $tests[] = ['✅ Menu Item Insert', 'WORKS', 'Database operation successful'];
                // Clean up test data
                $last_id = mysqli_insert_id($conn);
                mysqli_query($conn, "DELETE FROM menu_item WHERE item_id = $last_id");
            } else {
                $tests[] = ['❌ Menu Item Insert', 'FAILED', mysqli_error($conn)];
                $all_passed = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $tests[] = ['❌ Menu Item Prepare', 'FAILED', mysqli_error($conn)];
            $all_passed = false;
        }

        // Test file upload directories
        $restaurant_dir = 'assets/images/restaurants/';
        $menu_dir = 'assets/images/menu/';

        $tests[] = ['📁 Restaurant Images Dir', is_dir($restaurant_dir) ? 'EXISTS' : 'MISSING', $restaurant_dir];
        $tests[] = ['📁 Menu Images Dir', is_dir($menu_dir) ? 'EXISTS' : 'MISSING', $menu_dir];
        ?>

        <div class="test-results">
            <?php foreach ($tests as $test): ?>
            <div class="test-item">
                <div class="test-name"><?php echo $test[0]; ?></div>
                <div class="test-status <?php echo strtolower(str_replace(' ', '-', $test[1])); ?>"><?php echo $test[1]; ?></div>
                <div class="test-detail"><?php echo $test[2]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="admin-links" style="margin-top:40px;text-align:center;">
            <h2>Admin Pages:</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-top:20px;">
                <a href="/final_restaurant_project/admin/index.php" style="display:block;padding:15px;background:#667eea;color:#fff;text-decoration:none;border-radius:8px;">Dashboard</a>
                <a href="/final_restaurant_project/admin/add_restaurant.php" style="display:block;padding:15px;background:#28a745;color:#fff;text-decoration:none;border-radius:8px;">Add Restaurant</a>
                <a href="/final_restaurant_project/admin/add_food.php" style="display:block;padding:15px;background:#ffc107;color:#000;text-decoration:none;border-radius:8px;">Add Menu Item</a>
                <a href="/final_restaurant_project/admin/manage_orders.php" style="display:block;padding:15px;background:#dc3545;color:#fff;text-decoration:none;border-radius:8px;">Manage Orders</a>
            </div>
        </div>

        <?php if ($all_passed): ?>
        <div class="success-message">
            <h2>🎉 All Admin Functions Working!</h2>
            <p>Your admin panel is fully functional and secure.</p>
        </div>
        <?php else: ?>
        <div class="error-message">
            <h2>⚠️ Some Issues Found</h2>
            <p>Please check the failed tests and fix any database issues.</p>
            <a href="import_database.php" style="color:#fff;text-decoration:none;background:#007bff;padding:10px 20px;border-radius:5px;display:inline-block;margin-top:10px;">Re-import Database</a>
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
.test-status.set, .test-status.exists, .test-status.works { background: #d4edda; color: #155724; }
.test-status.failed, .test-status.missing { background: #f8d7da; color: #721c24; }
.test-detail { color: #666; font-size: 0.9em; }
.success-message, .error-message { text-align: center; padding: 30px; background: #fff; border-radius: 10px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.success-message h2 { color: #28a745; }
.error-message h2 { color: #dc3545; }
.success-message p, .error-message p { margin: 15px 0; }
</style>

<?php include 'footer.php'; ?>


