<?php include 'header.php'; ?>

<section class="header-showcase">
    <div class="wrap">
        <h1>🎨 Enhanced Header Navigation Design</h1>
        <p>Your blue header links now have premium styling with modern effects!</p>

        <div class="design-features">
            <div class="feature-card">
                <h3>✨ Gradient Backgrounds</h3>
                <p>Beautiful gradient colors for each navigation type</p>
                <div class="color-samples">
                    <span class="color-sample login">Login</span>
                    <span class="color-sample register">Register</span>
                    <span class="color-sample admin">Admin</span>
                    <span class="color-sample cart">Cart</span>
                </div>
            </div>

            <div class="feature-card">
                <h3>🎭 Hover Animations</h3>
                <p>Smooth lift effects and shimmer animations</p>
                <div class="animation-demo">
                    <button class="btn btn-primary demo-btn">Hover Me!</button>
                    <p>Try hovering over the navigation links above</p>
                </div>
            </div>

            <div class="feature-card">
                <h3>📱 Responsive Design</h3>
                <p>Adapts beautifully to all screen sizes</p>
                <div class="responsive-info">
                    <p><strong>Desktop:</strong> Horizontal layout with gaps</p>
                    <p><strong>Mobile:</strong> Stacked vertical layout</p>
                    <p><strong>Tablet:</strong> Wrapped horizontal layout</p>
                </div>
            </div>

            <div class="feature-card">
                <h3>🎯 Smart Cart Badge</h3>
                <p>Dynamic cart count with eye-catching styling</p>
                <div class="cart-demo">
                    <span class="cart-link">Cart <span class="cart-badge">5</span></span>
                    <span class="cart-link">Cart <span class="cart-badge cart-empty">0</span></span>
                </div>
            </div>
        </div>

        <div class="navigation-guide">
            <h2>🧭 Navigation Guide</h2>
            <div class="nav-examples">
                <div class="nav-group">
                    <h4>🔐 Authentication Links</h4>
                    <div class="nav-links">
                        <a href="#" class="nav-sample login">Login</a>
                        <a href="#" class="nav-sample register">Register</a>
                        <a href="#" class="nav-sample logout">Logout</a>
                    </div>
                </div>

                <div class="nav-group">
                    <h4>🍽️ Main Navigation</h4>
                    <div class="nav-links">
                        <a href="#" class="nav-sample home">Home</a>
                        <a href="#" class="nav-sample restaurants">Restaurants</a>
                        <a href="#" class="nav-sample gallery">Gallery</a>
                    </div>
                </div>

                <div class="nav-group">
                    <h4>⚙️ Special Features</h4>
                    <div class="nav-links">
                        <a href="#" class="nav-sample reservation">My Reservations</a>
                        <a href="#" class="nav-sample admin">Admin</a>
                        <a href="#" class="nav-sample cart">Cart <span class="cart-badge">3</span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="performance-tips">
            <h2>⚡ Performance & Accessibility</h2>
            <ul>
                <li>✅ <strong>Smooth Transitions:</strong> 0.3s ease animations</li>
                <li>✅ <strong>Focus States:</strong> Keyboard navigation support</li>
                <li>✅ <strong>Touch Friendly:</strong> Proper tap targets for mobile</li>
                <li>✅ <strong>Color Contrast:</strong> WCAG compliant accessibility</li>
                <li>✅ <strong>Reduced Motion:</strong> Respects user preferences</li>
                <li>✅ <strong>Progressive Enhancement:</strong> Works without JavaScript</li>
            </ul>
        </div>
    </div>
</section>

<style>
.header-showcase { padding: 40px 0; }
.header-showcase h1 { text-align: center; margin-bottom: 10px; color: #333; }
.header-showcase > .wrap > p { text-align: center; color: #666; margin-bottom: 50px; }

.design-features { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-bottom: 60px; }
.feature-card { background: #fff; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); text-align: center; }
.feature-card h3 { color: #333; margin-bottom: 15px; }
.feature-card p { color: #666; margin-bottom: 20px; }

.color-samples { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.color-sample { padding: 8px 16px; border-radius: 20px; color: #fff; font-size: 12px; font-weight: 500; }
.color-sample.login { background: linear-gradient(135deg, #28a745, #20c997); }
.color-sample.register { background: linear-gradient(135deg, #ffc107, #ff6b6b); }
.color-sample.admin { background: linear-gradient(135deg, #ff6b6b, #ee4266); }
.color-sample.cart { background: linear-gradient(135deg, #667eea, #764ba2); }

.animation-demo { margin-top: 20px; }
.demo-btn { margin-bottom: 15px; }

.responsive-info p { margin: 8px 0; text-align: left; }

.cart-demo { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
.cart-link { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; padding: 10px 18px; border-radius: 25px; text-decoration: none; font-weight: 500; }

.navigation-guide { background: #fff; border-radius: 15px; padding: 30px; margin: 40px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.navigation-guide h2 { text-align: center; margin-bottom: 30px; color: #333; }

.nav-examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
.nav-group h4 { color: #495057; margin-bottom: 15px; text-align: center; }
.nav-links { display: flex; flex-direction: column; gap: 10px; }

.nav-sample { display: block; padding: 12px 20px; border-radius: 25px; text-decoration: none; font-weight: 500; text-align: center; font-size: 14px; transition: all 0.3s ease; }
.nav-sample:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.3); }

.nav-sample.login { background: linear-gradient(135deg, rgba(40,167,69,0.8), rgba(32,201,151,0.8)); color: #fff; }
.nav-sample.register { background: linear-gradient(135deg, rgba(255,193,7,0.8), rgba(255,107,107,0.8)); color: #fff; }
.nav-sample.logout { background: linear-gradient(135deg, rgba(220,53,69,0.8), rgba(253,126,20,0.8)); color: #fff; }
.nav-sample.home { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; }
.nav-sample.restaurants { background: linear-gradient(135deg, rgba(23,162,184,0.8), rgba(102,16,242,0.8)); color: #fff; }
.nav-sample.gallery { background: linear-gradient(135deg, rgba(255,107,107,0.8), rgba(238,66,102,0.8)); color: #fff; }
.nav-sample.reservation { background: linear-gradient(135deg, rgba(23,162,184,0.8), rgba(102,16,242,0.8)); color: #fff; }
.nav-sample.admin { background: linear-gradient(135deg, rgba(255,107,107,0.8), rgba(238,66,102,0.8)); color: #fff; font-weight: 600; }
.nav-sample.cart { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; position: relative; }

.performance-tips { background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.performance-tips h2 { text-align: center; margin-bottom: 25px; color: #333; }
.performance-tips ul { list-style: none; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; }
.performance-tips li { padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #667eea; }
.performance-tips strong { color: #495057; }

@media(max-width:768px) {
    .design-features { grid-template-columns: 1fr; }
    .nav-examples { grid-template-columns: 1fr; }
    .color-samples, .cart-demo { justify-content: center; }
    .performance-tips ul { grid-template-columns: 1fr; }
}
</style>

<?php include 'footer.php'; ?>


