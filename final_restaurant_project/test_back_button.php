<?php include 'header.php'; ?>

<section class="back-button-showcase">
    <div class="wrap">
        <h1>🎨 Enhanced "Back to Site" Button Design</h1>
        <p>The admin "Back to Site" buttons now have premium styling with smooth animations!</p>

        <div class="button-showcase">
            <h2>✨ Premium Button Features</h2>

            <div class="button-examples">
                <div class="button-card">
                    <h3>Original Design</h3>
                    <p>Plain text link with basic styling</p>
                    <a href="#" style="color:#666;text-decoration:none;">← Back to Site</a>
                    <div class="note">❌ Basic, not visually appealing</div>
                </div>

                <div class="button-card">
                    <h3>Enhanced Design</h3>
                    <p>Premium button with gradients and animations</p>
                    <a href="#" class="back-to-site-btn">← Back to Main Site</a>
                    <div class="note">✅ Professional, eye-catching, interactive</div>
                </div>
            </div>

            <div class="features-list">
                <h3>🎯 Design Improvements</h3>
                <div class="features-grid">
                    <div class="feature-item">
                        <h4>🌈 Gradient Background</h4>
                        <p>Beautiful green gradient (success/action color) that indicates returning to main site</p>
                    </div>
                    <div class="feature-item">
                        <h4>✨ Shimmer Animation</h4>
                        <p>Smooth light sweep across the button on hover for premium feel</p>
                    </div>
                    <div class="feature-item">
                        <h4>🎭 Hover Effects</h4>
                        <p>Lift animation (-3px) with enhanced shadow for tactile feedback</p>
                    </div>
                    <div class="feature-item">
                        <h4>🎨 Consistent Styling</h4>
                        <p>Same premium button style across all admin pages</p>
                    </div>
                    <div class="feature-item">
                        <h4>📱 Responsive Design</h4>
                        <p>Adapts perfectly to different screen sizes</p>
                    </div>
                    <div class="feature-item">
                        <h4>♿ Accessibility</h4>
                        <p>Focus states and keyboard navigation support</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="live-demo">
            <h2>🔍 Live Demo</h2>
            <p>Visit any admin page to see the enhanced "Back to Site" button in action:</p>

            <div class="demo-links">
                <a href="/final_restaurant_project/admin/" class="demo-btn">Admin Dashboard</a>
                <a href="/final_restaurant_project/admin/manage_orders.php" class="demo-btn">Manage Orders</a>
                <a href="/final_restaurant_project/admin/add_restaurant.php" class="demo-btn">Add Restaurant</a>
                <a href="/final_restaurant_project/admin/add_food.php" class="demo-btn">Add Menu Item</a>
            </div>

            <div class="demo-instructions">
                <h3>💡 How to Test:</h3>
                <ul>
                    <li>Click any demo link above</li>
                    <li>Look for the green "← Back to Main Site" button</li>
                    <li>Hover over it to see the shimmer and lift effects</li>
                    <li>Notice how it stands out from other navigation</li>
                </ul>
            </div>
        </div>

        <div class="comparison">
            <h2>⚖️ Before vs After</h2>
            <div class="comparison-table">
                <div class="comparison-row">
                    <div class="comparison-cell">
                        <h4>Before</h4>
                        <div class="old-button">
                            <a href="#" style="color:#666;text-decoration:none;">← Back to Site</a>
                        </div>
                        <ul>
                            <li>❌ Plain text link</li>
                            <li>❌ No visual appeal</li>
                            <li>❌ Hard to notice</li>
                            <li>❌ No interaction feedback</li>
                        </ul>
                    </div>
                    <div class="comparison-cell">
                        <h4>After</h4>
                        <div class="new-button">
                            <a href="#" class="back-to-site-btn">← Back to Main Site</a>
                        </div>
                        <ul>
                            <li>✅ Premium gradient button</li>
                            <li>✅ Eye-catching design</li>
                            <li>✅ Smooth animations</li>
                            <li>✅ Interactive feedback</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.back-button-showcase { padding: 40px 0; }
.back-button-showcase h1 { text-align: center; margin-bottom: 10px; color: #333; }
.back-button-showcase > .wrap > p { text-align: center; color: #666; margin-bottom: 50px; }

.button-showcase { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.button-showcase h2 { text-align: center; margin-bottom: 30px; color: #333; }

.button-examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 40px; }
.button-card { background: #f8f9fa; border-radius: 10px; padding: 25px; text-align: center; border: 1px solid #dee2e6; }
.button-card h3 { margin: 0 0 10px 0; color: #495057; }
.button-card p { margin: 0 0 20px 0; color: #6c757d; }
.button-card a { display: inline-block; margin-bottom: 15px; }
.old-button a { color: #666 !important; text-decoration: none !important; font-size: 16px; }
.new-button .back-to-site-btn { margin: 0; }
.note { font-size: 14px; font-weight: 500; color: #495057; }

.features-list { margin-top: 40px; }
.features-list h3 { text-align: center; margin-bottom: 30px; color: #333; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
.feature-item { background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
.feature-item h4 { margin: 0 0 10px 0; color: #495057; }
.feature-item p { margin: 0; color: #6c757d; font-size: 0.9em; }

.live-demo { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.live-demo h2 { text-align: center; margin-bottom: 15px; color: #333; }
.live-demo > p { text-align: center; color: #666; margin-bottom: 30px; }

.demo-links { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px; }
.demo-btn { display: inline-block; padding: 12px 20px; background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 500; transition: all 0.3s ease; }
.demo-btn:hover { background: linear-gradient(135deg, #667eea, #764ba2); transform: translateY(-2px); }

.demo-instructions { background: #f8f9fa; padding: 20px; border-radius: 10px; }
.demo-instructions h3 { margin: 0 0 15px 0; color: #495057; }
.demo-instructions ul { margin: 0; padding-left: 20px; }
.demo-instructions li { margin: 8px 0; color: #666; }

.comparison { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.comparison h2 { text-align: center; margin-bottom: 30px; color: #333; }

.comparison-table { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.comparison-row { display: contents; }
.comparison-cell { background: #f8f9fa; border-radius: 10px; padding: 25px; text-align: center; }
.comparison-cell h4 { margin: 0 0 20px 0; color: #495057; font-size: 1.2em; }
.comparison-cell ul { text-align: left; margin: 0; padding-left: 20px; }
.comparison-cell li { margin: 8px 0; color: #666; }

.back-to-site-btn { display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9)); color: #fff; text-decoration: none; border-radius: 25px; font-weight: 500; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s ease; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 4px 15px rgba(40,167,69,0.3); }
.back-to-site-btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.5s ease; }
.back-to-site-btn:hover { background: linear-gradient(135deg, #28a745, #20c997); transform: translateY(-3px); box-shadow: 0 8px 25px rgba(40,167,69,0.4); border-color: rgba(255,255,255,0.4); }
.back-to-site-btn:hover::before { left: 100%; }
.back-to-site-btn:focus { outline: none; box-shadow: 0 0 0 4px rgba(40,167,69,0.3); }
.back-to-site-btn:active { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(40,167,69,0.2); }

@media(max-width:768px) {
    .button-examples { grid-template-columns: 1fr; }
    .features-grid { grid-template-columns: 1fr; }
    .comparison-table { grid-template-columns: 1fr; gap: 20px; }
    .demo-links { flex-direction: column; align-items: center; }
}
</style>

<?php include 'footer.php'; ?>


