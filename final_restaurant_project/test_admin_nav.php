<?php include 'header.php'; ?>

<section class="admin-nav-test">
    <div class="wrap">
        <h1>🧪 Admin Navigation Consistency Test</h1>
        <p>All admin pages now have premium navigation styling!</p>

        <div class="admin-showcase">
            <h2>✨ Enhanced Admin Navigation</h2>
            <p>All admin pages now feature premium gradient buttons with smooth animations and consistent styling.</p>

            <div class="admin-pages-grid">
                <div class="admin-page-card">
                    <h3>📊 Dashboard</h3>
                    <a href="/final_restaurant_project/admin/" class="admin-nav-btn">Dashboard</a>
                    <p>Main admin overview with statistics</p>
                </div>

                <div class="admin-page-card">
                    <h3>📋 Manage Orders</h3>
                    <a href="/final_restaurant_project/admin/manage_orders.php" class="admin-nav-btn">Manage Orders</a>
                    <p>View and update order status</p>
                </div>

                <div class="admin-page-card">
                    <h3>🏪 Add Restaurant</h3>
                    <a href="/final_restaurant_project/admin/add_restaurant.php" class="admin-nav-btn">Add Restaurant</a>
                    <p>Create new restaurant entries</p>
                </div>

                <div class="admin-page-card">
                    <h3>🍽️ Add Menu Item</h3>
                    <a href="/final_restaurant_project/admin/add_food.php" class="admin-nav-btn">Add Menu Item</a>
                    <p>Add food items to restaurants</p>
                </div>

                <div class="admin-page-card">
                    <h3>👁️ View Restaurants</h3>
                    <a href="/final_restaurant_project/admin/restaurant.php" class="admin-nav-btn">View Restaurants</a>
                    <p>Browse all restaurant listings</p>
                </div>

                <div class="admin-page-card">
                    <h3>✏️ Edit Restaurant</h3>
                    <a href="/final_restaurant_project/admin/edit_restaurant.php?id=1" class="admin-nav-btn">Edit Restaurant</a>
                    <p>Modify existing restaurants</p>
                </div>

                <div class="admin-page-card">
                    <h3>✏️ Edit Menu Item</h3>
                    <a href="/final_restaurant_project/admin/edit_menu_item.php?id=1" class="admin-nav-btn">Edit Menu Item</a>
                    <p>Update food item details</p>
                </div>

                <div class="admin-page-card">
                    <h3>🔙 Back to Site</h3>
                    <a href="/final_restaurant_project/" class="admin-nav-btn back">Back to Site</a>
                    <p>Return to main website</p>
                </div>
            </div>
        </div>

        <div class="nav-features">
            <h2>✅ Premium Navigation Features</h2>
            <div class="features-list">
                <div class="feature-item">
                    <h4>🎨 Gradient Backgrounds</h4>
                    <p>Beautiful blue gradient backgrounds on all admin navigation buttons</p>
                </div>
                <div class="feature-item">
                    <h4>✨ Hover Animations</h4>
                    <p>Smooth lift effects and shimmer animations on hover</p>
                </div>
                <div class="feature-item">
                    <h4>📱 Responsive Design</h4>
                    <p>Navigation adapts perfectly to desktop, tablet, and mobile screens</p>
                </div>
                <div class="feature-item">
                    <h4>🎯 Consistent Styling</h4>
                    <p>Same premium button style across all admin pages</p>
                </div>
                <div class="feature-item">
                    <h4>♿ Accessibility</h4>
                    <p>Keyboard navigation and focus states for all users</p>
                </div>
                <div class="feature-item">
                    <h4>⚡ Performance</h4>
                    <p>Optimized animations with hardware acceleration</p>
                </div>
            </div>
        </div>

        <div class="live-demo">
            <h2>🔍 Live Demo</h2>
            <p>Click any button above to see the premium navigation styling in action on real admin pages!</p>
            <div class="demo-tips">
                <h3>💡 Pro Tips:</h3>
                <ul>
                    <li>Hover over buttons to see the shimmer effect</li>
                    <li>Notice the smooth lift animation on interaction</li>
                    <li>Try on mobile - buttons adapt perfectly</li>
                    <li>All admin pages now have consistent navigation</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.admin-nav-test { padding: 40px 0; }
.admin-nav-test h1 { text-align: center; margin-bottom: 10px; color: #333; }
.admin-nav-test > .wrap > p { text-align: center; color: #666; margin-bottom: 50px; }

.admin-showcase { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.admin-showcase h2 { text-align: center; margin-bottom: 15px; color: #333; }
.admin-showcase > p { text-align: center; color: #666; margin-bottom: 30px; }

.admin-pages-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 30px; }
.admin-page-card { background: #f8f9fa; border-radius: 10px; padding: 20px; text-align: center; border: 1px solid #dee2e6; transition: transform 0.3s ease; }
.admin-page-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.admin-page-card h3 { margin: 0 0 15px 0; color: #495057; font-size: 1.1em; }
.admin-page-card p { margin: 15px 0; color: #6c757d; font-size: 0.9em; }

.admin-nav-btn { display: inline-block; background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 25px; font-weight: 500; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s ease; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.admin-nav-btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s ease; }
.admin-nav-btn:hover { background: linear-gradient(135deg, #667eea, #764ba2); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.3); border-color: rgba(255,255,255,0.3); }
.admin-nav-btn:hover::before { left: 100%; }
.admin-nav-btn:focus { outline: none; box-shadow: 0 0 0 3px rgba(102,126,234,0.5); }
.admin-nav-btn:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.admin-nav-btn.back { background: linear-gradient(135deg, rgba(108,117,125,0.8), rgba(73,80,87,0.8)); }
.admin-nav-btn.back:hover { background: linear-gradient(135deg, #6c757d, #495057); }

.nav-features { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.nav-features h2 { text-align: center; margin-bottom: 30px; color: #333; }

.features-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
.feature-item { background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
.feature-item h4 { margin: 0 0 10px 0; color: #495057; }
.feature-item p { margin: 0; color: #6c757d; font-size: 0.9em; }

.live-demo { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.live-demo h2 { text-align: center; margin-bottom: 15px; color: #333; }
.live-demo > p { text-align: center; color: #666; margin-bottom: 30px; }

.demo-tips { background: #f8f9fa; padding: 20px; border-radius: 10px; }
.demo-tips h3 { margin: 0 0 15px 0; color: #495057; }
.demo-tips ul { margin: 0; padding-left: 20px; }
.demo-tips li { margin: 8px 0; color: #666; }

@media(max-width:768px) {
    .admin-pages-grid { grid-template-columns: 1fr; }
    .features-list { grid-template-columns: 1fr; }
    .admin-nav-btn { padding: 10px 20px; font-size: 13px; }
}
</style>

<?php include 'footer.php'; ?>


