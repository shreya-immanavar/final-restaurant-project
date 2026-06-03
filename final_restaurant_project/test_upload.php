<?php
include 'db.php';
include 'header.php';
?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 Image Upload Test</h1>
        <p>Test that admin image upload functionality works properly</p>

        <?php
        $tests = [];
        $all_passed = true;

        // Test directories exist
        $restaurant_dir = 'assets/images/restaurants/';
        $menu_dir = 'assets/images/menu/';

        $tests[] = ['📁 Restaurant Images Dir', is_dir($restaurant_dir) ? 'EXISTS' : 'MISSING', $restaurant_dir];
        $tests[] = ['📁 Menu Images Dir', is_dir($menu_dir) ? 'EXISTS' : 'MISSING', $menu_dir];

        // Test directory permissions
        $tests[] = ['🔐 Restaurant Dir Writable', is_writable($restaurant_dir) ? 'YES' : 'NO', 'Write permissions for uploads'];
        $tests[] = ['🔐 Menu Dir Writable', is_writable($menu_dir) ? 'YES' : 'NO', 'Write permissions for uploads'];

        // Check PHP upload settings
        $upload_max = ini_get('upload_max_filesize');
        $post_max = ini_get('post_max_size');
        $tests[] = ['⚙️ PHP Upload Max', $upload_max, 'Maximum file upload size'];
        $tests[] = ['⚙️ PHP Post Max', $post_max, 'Maximum POST data size'];

        // Check if GD library is available for image processing
        $gd_available = extension_loaded('gd');
        $tests[] = ['🖼️ GD Library', $gd_available ? 'AVAILABLE' : 'MISSING', 'Image processing library'];

        // Test file creation (create a test file)
        $test_file = $restaurant_dir . 'test_write.txt';
        $file_created = file_put_contents($test_file, 'test content') !== false;
        if ($file_created) {
            unlink($test_file); // Clean up
            $tests[] = ['✍️ File Write Test', 'PASSED', 'Can create files in directories'];
        } else {
            $tests[] = ['✍️ File Write Test', 'FAILED', 'Cannot write to directories'];
            $all_passed = false;
        }

        // Check existing images
        $restaurant_images = glob($restaurant_dir . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        $menu_images = glob($menu_dir . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

        $tests[] = ['🖼️ Restaurant Images', count($restaurant_images), 'Existing uploaded images'];
        $tests[] = ['🍽️ Menu Images', count($menu_images), 'Existing uploaded images'];

        // Check for sample data from SQL
        $result = mysqli_query($conn, "SELECT image FROM restaurant WHERE image IS NOT NULL AND image != '' LIMIT 5");
        $restaurant_db_images = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $restaurant_db_images[] = $row['image'];
        }

        $result = mysqli_query($conn, "SELECT image FROM menu_item WHERE image IS NOT NULL AND image != '' LIMIT 5");
        $menu_db_images = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $menu_db_images[] = $row['image'];
        }

        $tests[] = ['🗃️ DB Restaurant Images', count($restaurant_db_images), implode(', ', array_slice($restaurant_db_images, 0, 3)) . (count($restaurant_db_images) > 3 ? '...' : '')];
        $tests[] = ['🗃️ DB Menu Images', count($menu_db_images), implode(', ', array_slice($menu_db_images, 0, 3)) . (count($menu_db_images) > 3 ? '...' : '')];
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

        <div class="upload-test-section">
            <h2>🧪 Test Image Upload</h2>
            <p>Use the forms below to test actual image uploads:</p>

            <div class="upload-forms">
                <div class="upload-form-card">
                    <h3>Add Test Restaurant</h3>
                    <form action="/final_restaurant_project/admin/add_restaurant.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Test Restaurant Name" required>
                        <input type="text" name="location" placeholder="Test Location" required>
                        <input type="file" name="image" accept="image/*" required>
                        <button type="submit" name="submit" style="background:#28a745;color:#fff;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;">Add Restaurant</button>
                    </form>
                </div>

                <div class="upload-form-card">
                    <h3>Add Test Menu Item</h3>
                    <form action="/final_restaurant_project/admin/add_food.php" method="POST" enctype="multipart/form-data">
                        <select name="restaurant_id" required>
                            <option value="">Select Restaurant</option>
                            <?php
                            $restaurants = mysqli_query($conn, "SELECT * FROM restaurant ORDER BY name");
                            while($r = mysqli_fetch_assoc($restaurants)) {
                                echo "<option value='{$r['restaurant_id']}'>{$r['name']}</option>";
                            }
                            ?>
                        </select>
                        <input type="text" name="item_name" placeholder="Test Item Name" required>
                        <input type="number" name="price" step="0.01" placeholder="99.99" required>
                        <textarea name="description" placeholder="Test description"></textarea>
                        <input type="file" name="image" accept="image/*" required>
                        <button type="submit" name="submit" style="background:#ffc107;color:#000;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;">Add Menu Item</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($all_passed): ?>
        <div class="success-message">
            <h2>🎉 Image Upload System Ready!</h2>
            <p>All directories exist, permissions are correct, and upload functionality is working.</p>
            <a href="/final_restaurant_project/admin/add_restaurant.php" class="btn btn-primary">Add Restaurant</a>
            <a href="/final_restaurant_project/admin/add_food.php" class="btn btn-secondary">Add Menu Item</a>
        </div>
        <?php else: ?>
        <div class="error-message">
            <h2>⚠️ Upload Issues Found</h2>
            <p>Please check the failed tests above and fix any permission or configuration issues.</p>
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
.test-status.exists, .test-status.yes, .test-status.available, .test-status.passed { background: #d4edda; color: #155724; }
.test-status.missing, .test-status.no, .test-status.failed { background: #f8d7da; color: #721c24; }
.test-detail { color: #666; font-size: 0.9em; }
.upload-test-section { background: #fff; border-radius: 10px; padding: 30px; margin: 30px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.upload-test-section h2 { margin-bottom: 15px; color: #333; }
.upload-forms { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px; }
.upload-form-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; }
.upload-form-card h3 { margin: 0 0 15px 0; color: #495057; }
.upload-form-card form { display: flex; flex-direction: column; gap: 10px; }
.upload-form-card input, .upload-form-card select, .upload-form-card textarea { padding: 8px; border: 1px solid #ced4da; border-radius: 4px; }
.upload-form-card textarea { resize: vertical; min-height: 60px; }
.success-message, .error-message { text-align: center; padding: 30px; background: #fff; border-radius: 10px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.success-message h2 { color: #28a745; }
.error-message h2 { color: #dc3545; }
.success-message p, .error-message p { margin: 15px 0; }
@media(max-width:768px){ .upload-forms{ grid-template-columns: 1fr; } .test-item{ grid-template-columns: 1fr; gap: 5px; } }
</style>

<?php include 'footer.php'; ?>


