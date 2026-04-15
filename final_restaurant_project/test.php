<?php
include 'db.php';
include 'header.php';
?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 System Test Results</h1>

        <?php
        $tests = [];
        $all_passed = true;

        // Test 1: Database Connection
        if ($conn) {
            $tests[] = ['✅ Database Connection', 'PASSED', 'Connected to MySQL'];
        } else {
            $tests[] = ['❌ Database Connection', 'FAILED', 'Cannot connect to MySQL'];
            $all_passed = false;
        }

        // Test 2: Tables Exist
        $tables = ['customers', 'restaurant', 'menu_item', 'orders', 'order_item', 'delivery', 'payment', 'reservation'];
        foreach ($tables as $table) {
            $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
            if (mysqli_num_rows($result) > 0) {
                $tests[] = ["✅ Table '$table'", 'EXISTS', 'Table found'];
            } else {
                $tests[] = ["❌ Table '$table'", 'MISSING', 'Table not found'];
                $all_passed = false;
            }
        }

        // Test 3: Sample Data
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant");
        $restaurant_count = mysqli_fetch_assoc($result)['count'];
        $tests[] = ['📊 Sample Restaurants', $restaurant_count > 0 ? 'FOUND' : 'EMPTY', "$restaurant_count restaurants"];

        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item");
        $menu_count = mysqli_fetch_assoc($result)['count'];
        $tests[] = ['📊 Sample Menu Items', $menu_count > 0 ? 'FOUND' : 'EMPTY', "$menu_count menu items"];

        // Test 4: CSS Loading
        $css_exists = file_exists('assets/css/style.css');
        $tests[] = ['🎨 CSS File', $css_exists ? 'EXISTS' : 'MISSING', $css_exists ? 'Style file found' : 'Style file missing'];

        // Test 5: Images Directory
        $images_exist = is_dir('assets/images');
        $tests[] = ['🖼️ Images Directory', $images_exist ? 'EXISTS' : 'MISSING', $images_exist ? 'Images folder found' : 'Images folder missing'];
        ?>

        <div class="test-results">
            <?php foreach ($tests as $test): ?>
            <div class="test-item">
                <div class="test-name"><?php echo $test[0]; ?></div>
                <div class="test-status <?php echo strtolower($test[1]); ?>"><?php echo $test[1]; ?></div>
                <div class="test-detail"><?php echo $test[2]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ($all_passed): ?>
        <div class="success-message">
            <h2>🎉 All Tests Passed!</h2>
            <p>Your FoodieHub restaurant system is ready!</p>
            <a href="index.php" class="btn btn-primary">Go to Homepage</a>
        </div>
        <?php else: ?>
        <div class="error-message">
            <h2>⚠️ Some Issues Found</h2>
            <p>Please fix the failed tests before proceeding.</p>
            <a href="import_database.php" class="btn btn-primary">Import Database</a>
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
.test-status.passed, .test-status.exists, .test-status.found { background: #d4edda; color: #155724; }
.test-status.failed, .test-status.missing, .test-status.empty { background: #f8d7da; color: #721c24; }
.test-detail { color: #666; font-size: 0.9em; }
.success-message, .error-message { text-align: center; padding: 30px; background: #fff; border-radius: 10px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.success-message h2 { color: #28a745; }
.error-message h2 { color: #dc3545; }
.success-message p, .error-message p { margin: 15px 0; }
</style>

<?php include 'footer.php'; ?>


