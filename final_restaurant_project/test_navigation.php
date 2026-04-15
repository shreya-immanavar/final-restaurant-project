<?php include 'header.php'; ?>

<section class="test-section">
    <div class="wrap">
        <h1>🧪 Navigation Test</h1>
        <p>Test that all navigation links work from any page</p>

        <div class="nav-test-grid">
            <div class="nav-test-card">
                <h3>🏠 Homepage</h3>
                <a href="/final_restaurant_project/index.php" class="btn btn-primary">Test Home</a>
                <p>Should show featured restaurants</p>
            </div>

            <div class="nav-test-card">
                <h3>🍽️ Restaurants</h3>
                <a href="/final_restaurant_project/restaurants.php" class="btn btn-primary">Test Restaurants</a>
                <p>Should show all restaurants</p>
            </div>

            <div class="nav-test-card">
                <h3>🛒 Cart</h3>
                <a href="/final_restaurant_project/cart.php" class="btn btn-primary">Test Cart</a>
                <p>Should show shopping cart</p>
            </div>

            <div class="nav-test-card">
                <h3>📅 Reservations</h3>
                <a href="/final_restaurant_project/reservation/book.php" class="btn btn-primary">Test Reservation</a>
                <p>Should show reservation form</p>
            </div>

            <div class="nav-test-card">
                <h3>🔐 Login</h3>
                <a href="/final_restaurant_project/auth/login.php" class="btn btn-primary">Test Login</a>
                <p>Should show login form</p>
            </div>

            <div class="nav-test-card">
                <h3>📝 Register</h3>
                <a href="/final_restaurant_project/auth/register.php" class="btn btn-primary">Test Register</a>
                <p>Should show registration form</p>
            </div>

            <div class="nav-test-card">
                <h3>⚙️ Admin</h3>
                <a href="/final_restaurant_project/admin/index.php" class="btn btn-primary">Test Admin</a>
                <p>Should show admin dashboard</p>
            </div>

            <div class="nav-test-card">
                <h3>🧪 System Test</h3>
                <a href="/final_restaurant_project/test.php" class="btn btn-primary">Test System</a>
                <p>Should show system status</p>
            </div>
        </div>

        <div class="test-info">
            <h2>✅ Navigation Fixed!</h2>
            <p>All links now use absolute paths (<code>/final_restaurant_project/...</code>) so they work from any subdirectory.</p>

            <div class="path-examples">
                <h3>Path Examples:</h3>
                <ul>
                    <li><strong>From root:</strong> <code>index.php</code> → <code>/final_restaurant_project/index.php</code></li>
                    <li><strong>From /reservation/:</strong> <code>index.php</code> → <code>/final_restaurant_project/index.php</code></li>
                    <li><strong>From /auth/:</strong> <code>index.php</code> → <code>/final_restaurant_project/index.php</code></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.test-section { padding: 40px 0; }
.nav-test-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0; }
.nav-test-card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); text-align: center; }
.nav-test-card h3 { margin: 0 0 15px 0; color: #333; }
.nav-test-card p { margin: 15px 0; color: #666; font-size: 0.9em; }
.test-info { background: #fff; border-radius: 10px; padding: 30px; margin: 30px 0; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
.test-info h2 { color: #28a745; margin-bottom: 15px; }
.test-info p { margin-bottom: 20px; color: #666; }
.path-examples { background: #f8f9fa; padding: 20px; border-radius: 8px; }
.path-examples h3 { margin: 0 0 15px 0; color: #333; }
.path-examples ul { margin: 0; padding-left: 20px; }
.path-examples li { margin: 8px 0; color: #666; }
.path-examples code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
</style>

<?php include 'footer.php'; ?>


