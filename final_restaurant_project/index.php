<?php
include_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>FoodieHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/final_restaurant_project/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="wrap">
        <div class="hero-content">
            <h1>Welcome to FoodieHub</h1>
            <p>Discover amazing restaurants and delicious food delivered to your doorstep</p>
            <a href="restaurants.php" class="btn btn-primary">Explore Restaurants</a>
        </div>
    </div>
</section>

<!-- Featured Restaurants -->
<section class="featured-restaurants">
    <div class="wrap">
        <h2>Featured Restaurants</h2>
        <div class="restaurants-grid">
            <?php
            // Safe restaurant query
            $restaurants = mysqli_query($conn, "SELECT * FROM restaurant LIMIT 6");
            if($restaurants && mysqli_num_rows($restaurants) > 0):
                while($restaurant = mysqli_fetch_assoc($restaurants)):
            ?>
            <div class="restaurant-card">
                <div class="restaurant-image">
                    <?php if($restaurant['image'] && file_exists('assets/images/restaurants/' . $restaurant['image'])): ?>
                        <img src="assets/images/restaurants/<?php echo htmlspecialchars($restaurant['image']); ?>" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
                    <?php else: ?>
                        <div class="image-placeholder">
                            <span><?php echo htmlspecialchars(substr($restaurant['name'], 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="restaurant-info">
                    <h3><?php echo htmlspecialchars($restaurant['name']); ?></h3>
                    <p><?php echo htmlspecialchars($restaurant['location']); ?></p>
                    <a href="restaurant.php?id=<?php echo $restaurant['restaurant_id']; ?>" class="btn btn-secondary">View Menu</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo "<p>No restaurants available at the moment.</p>";
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="wrap">
        <h2>Why Choose FoodieHub?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🍕</div>
                <h3>Wide Variety</h3>
                <p>Choose from hundreds of restaurants offering diverse cuisines</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Fast Delivery</h3>
                <p>Quick and reliable delivery to your doorstep</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Easy Payment</h3>
                <p>Secure payment options for a hassle-free experience</p>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
