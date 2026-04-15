<?php include 'header.php'; ?>

<section class="restaurants-section">
    <div class="wrap">
        <h1>All Restaurants</h1>
        <p>Discover delicious food from our partner restaurants</p>

        <div class="restaurants-grid">
            <?php
            $restaurants = mysqli_query($conn, "SELECT * FROM restaurant ORDER BY name");
            if(mysqli_num_rows($restaurants) > 0):
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
                    <a href="/final_restaurant_project/reservation/book.php" class="btn btn-secondary">Make a Reservation</a>
                </div>
            </div>

            <?php
                endwhile;
            else:
            ?>
            <div class="no-restaurants">
                <p>No restaurants available at the moment. Please check back later.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
