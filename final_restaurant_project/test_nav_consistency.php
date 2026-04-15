<?php include 'header.php'; ?>

<section class="nav-consistency-test">
    <div class="wrap">
        <h1>🎨 Navigation Consistency Test</h1>
        <p>All header navigation buttons now have premium styling!</p>

        <div class="nav-showcase">
            <h2>✨ Enhanced Navigation Buttons</h2>
            <p>All navigation links now have consistent premium styling with gradients, hover effects, and animations.</p>

            <div class="nav-buttons-grid">
                <div class="nav-category">
                    <h3>🏠 Main Navigation</h3>
                    <div class="button-examples">
                        <a href="#" class="nav-btn home">Home</a>
                        <a href="#" class="nav-btn restaurants">Restaurants</a>
                        <a href="#" class="nav-btn gallery">Gallery</a>
                        <a href="#" class="nav-btn cart">Cart <span class="cart-badge">3</span></a>
                    </div>
                </div>

                <div class="nav-category">
                    <h3>🔐 Authentication</h3>
                    <div class="button-examples">
                        <a href="#" class="nav-btn login">Login</a>
                        <a href="#" class="nav-btn register">Register</a>
                        <a href="#" class="nav-btn logout">Logout</a>
                        <a href="#" class="nav-btn reservation">My Reservations</a>
                    </div>
                </div>

                <div class="nav-category">
                    <h3>⚙️ Administration</h3>
                    <div class="button-examples">
                        <a href="#" class="nav-btn admin">Admin</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="consistency-features">
            <h2>✅ Consistency Features</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <h4>🎨 Unified Design</h4>
                    <p>All navigation buttons share the same premium styling with consistent padding, borders, and typography.</p>
                </div>
                <div class="feature-item">
                    <h4>🌈 Smart Colors</h4>
                    <p>Each button type has its own meaningful color scheme for better user recognition.</p>
                </div>
                <div class="feature-item">
                    <h4>✨ Interactive Effects</h4>
                    <p>Hover animations, focus states, and active feedback for enhanced user experience.</p>
                </div>
                <div class="feature-item">
                    <h4>📱 Responsive Design</h4>
                    <p>Buttons adapt beautifully across all device sizes with appropriate touch targets.</p>
                </div>
            </div>
        </div>

        <div class="live-test">
            <h2>🔍 Live Test</h2>
            <p>Check the actual header navigation above to see the consistent styling in action!</p>
            <div class="test-instructions">
                <h3>How to Test:</h3>
                <ol>
                    <li>Look at the header navigation above</li>
                    <li>Hover over different buttons to see animations</li>
                    <li>Notice the consistent styling across all button types</li>
                    <li>Resize your browser to test mobile responsiveness</li>
                    <li>Try keyboard navigation (Tab key) for focus states</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<style>
.nav-consistency-test { padding: 40px 0; }
.nav-consistency-test h1 { text-align: center; margin-bottom: 10px; color: #333; }
.nav-consistency-test > .wrap > p { text-align: center; color: #666; margin-bottom: 50px; }

.nav-showcase { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.nav-showcase h2 { text-align: center; margin-bottom: 15px; color: #333; }
.nav-showcase > p { text-align: center; color: #666; margin-bottom: 30px; }

.nav-buttons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 30px; }
.nav-category h3 { color: #495057; margin-bottom: 20px; text-align: center; }
.button-examples { display: flex; flex-direction: column; gap: 15px; }

.nav-btn { display: block; background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); color: #fff; text-decoration: none; padding: 12px 20px; border-radius: 25px; font-weight: 500; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s ease; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
.nav-btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s ease; }
.nav-btn:hover { background: linear-gradient(135deg, #667eea, #764ba2); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.3); border-color: rgba(255,255,255,0.3); }
.nav-btn:hover::before { left: 100%; }
.nav-btn:focus { outline: none; box-shadow: 0 0 0 3px rgba(102,126,234,0.5); }
.nav-btn:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

.nav-btn.home { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); }
.nav-btn.restaurants { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); }
.nav-btn.gallery { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); }
.nav-btn.cart { background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8)); }
.nav-btn.login { background: linear-gradient(135deg, rgba(40,167,69,0.8), rgba(32,201,151,0.8)); }
.nav-btn.register { background: linear-gradient(135deg, rgba(255,193,7,0.8), rgba(255,107,107,0.8)); }
.nav-btn.logout { background: linear-gradient(135deg, rgba(220,53,69,0.8), rgba(253,126,20,0.8)); }
.nav-btn.reservation { background: linear-gradient(135deg, rgba(23,162,184,0.8), rgba(102,16,242,0.8)); }
.nav-btn.admin { background: linear-gradient(135deg, rgba(255,107,107,0.8), rgba(238,66,102,0.8)); font-weight: 600; }

.consistency-features { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.consistency-features h2 { text-align: center; margin-bottom: 30px; color: #333; }

.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.feature-item { background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
.feature-item h4 { margin: 0 0 10px 0; color: #495057; }
.feature-item p { margin: 0; color: #666; font-size: 0.9em; }

.live-test { background: #fff; border-radius: 15px; padding: 30px; margin: 30px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
.live-test h2 { text-align: center; margin-bottom: 15px; color: #333; }
.live-test > p { text-align: center; color: #666; margin-bottom: 30px; }

.test-instructions { background: #f8f9fa; padding: 20px; border-radius: 10px; }
.test-instructions h3 { margin: 0 0 15px 0; color: #495057; }
.test-instructions ol { margin: 0; padding-left: 20px; }
.test-instructions li { margin: 8px 0; color: #666; }

.cart-badge { background: linear-gradient(135deg, #ff6b6b, #ee5a24); color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; margin-left: 6px; min-width: 18px; text-align: center; display: inline-block; box-shadow: 0 2px 4px rgba(255,107,107,0.3); }

@media(max-width:768px) {
    .nav-buttons-grid { grid-template-columns: 1fr; }
    .features-grid { grid-template-columns: 1fr; }
    .button-examples { gap: 10px; }
    .nav-btn { padding: 10px 16px; font-size: 13px; }
}
</style>

<?php include 'footer.php'; ?>


