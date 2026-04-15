<?php
include 'db.php';
include 'header.php';
?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 Reservation & Checkout Test</h1>

        <?php
        $tests = [];
        $all_passed = true;

        // Test database connection
        if ($conn) {
            $tests[] = ['✅ Database Connection', 'PASSED', 'Connected successfully'];
        } else {
            $tests[] = ['❌ Database Connection', 'FAILED', 'Connection failed'];
            $all_passed = false;
        }

        // Test reservation table
        $result = mysqli_query($conn, "DESCRIBE reservation");
        if ($result && mysqli_num_rows($result) > 0) {
            $tests[] = ['✅ Reservation Table', 'EXISTS', 'Table structure OK'];
        } else {
            $tests[] = ['❌ Reservation Table', 'MISSING', 'Table not found'];
            $all_passed = false;
        }

        // Test orders table
        $result = mysqli_query($conn, "DESCRIBE orders");
        if ($result && mysqli_num_rows($result) > 0) {
            $tests[] = ['✅ Orders Table', 'EXISTS', 'Table structure OK'];
        } else {
            $tests[] = ['❌ Orders Table', 'MISSING', 'Table not found'];
            $all_passed = false;
        }

        // Test sample data
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant");
        $restaurant_count = mysqli_fetch_assoc($result)['count'];
        $tests[] = ['📊 Restaurants', $restaurant_count > 0 ? 'FOUND' : 'EMPTY', "$restaurant_count restaurants"];

        // Test reservation insert (dry run)
        $stmt = mysqli_prepare($conn, "INSERT INTO reservation (customer_id, restaurant_id, r_date, r_time, people) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $test_customer = 1;
            $test_restaurant = 1;
            $test_date = '2025-12-25';
            $test_time = '18:00';
            $test_people = 2;

            mysqli_stmt_bind_param($stmt, "iissi", $test_customer, $test_restaurant, $test_date, $test_time, $test_people);

            if (mysqli_stmt_execute($stmt)) {
                $tests[] = ['✅ Reservation Insert', 'WORKS', 'SQL binding OK'];
                // Rollback the test insert
                $last_id = mysqli_insert_id($conn);
                mysqli_query($conn, "DELETE FROM reservation WHERE reservation_id = $last_id");
            } else {
                $tests[] = ['❌ Reservation Insert', 'FAILED', mysqli_error($conn)];
                $all_passed = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $tests[] = ['❌ Reservation Prepare', 'FAILED', mysqli_error($conn)];
            $all_passed = false;
        }

        // Test order insert (dry run)
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, restaurant_id, total_amount, status) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $test_customer = 1;
            $test_restaurant = 1;
            $test_total = 500.00;
            $test_status = 'Placed';

            mysqli_stmt_bind_param($stmt, "iids", $test_customer, $test_restaurant, $test_total, $test_status);

            if (mysqli_stmt_execute($stmt)) {
                $tests[] = ['✅ Order Insert', 'WORKS', 'SQL binding OK'];
                // Rollback the test insert
                $last_id = mysqli_insert_id($conn);
                mysqli_query($conn, "DELETE FROM orders WHERE order_id = $last_id");
            } else {
                $tests[] = ['❌ Order Insert', 'FAILED', mysqli_error($conn)];
                $all_passed = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $tests[] = ['❌ Order Prepare', 'FAILED', mysqli_error($conn)];
            $all_passed = false;
        }
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

        <?php if ($all_passed): ?>
        <div class="success-message">
            <h2>🎉 All Tests Passed!</h2>
            <p>Your reservation and checkout systems are working perfectly!</p>
            <a href="/final_restaurant_project/reservation/book.php" class="btn btn-primary">Test Reservation</a>
            <a href="/final_restaurant_project/restaurants.php" class="btn btn-secondary">Browse Restaurants</a>
        </div>
        <?php else: ?>
        <div class="error-message">
            <h2>⚠️ Some Issues Found</h2>
            <p>Please fix the failed tests before using the reservation system.</p>
            <a href="/final_restaurant_project/import_database.php" class="btn btn-primary">Re-import Database</a>
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
.test-status.passed, .test-status.exists, .test-status.found, .test-status.works { background: #d4edda; color: #155724; }
.test-status.failed, .test-status.missing, .test-status.empty { background: #f8d7da; color: #721c24; }
.test-detail { color: #666; font-size: 0.9em; }
.success-message, .error-message { text-align: center; padding: 30px; background: #fff; border-radius: 10px; margin: 20px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.success-message h2 { color: #28a745; }
.error-message h2 { color: #dc3545; }
.success-message p, .error-message p { margin: 15px 0; }
</style>

<?php include 'footer.php'; ?>
