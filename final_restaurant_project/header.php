<?php
include_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Restaurant System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/final_restaurant_project/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="site-header">
  <div class="wrap">
    <a class="logo" href="/final_restaurant_project/index.php">
        <span class="logo-icon">🍽️</span>
        <span class="logo-text">FoodieHub</span>
    </a>
    <nav class="main-nav">
      <!-- Left Navigation Links -->
      <div style="display:flex; gap:15px; align-items:center;">
        <a href="/final_restaurant_project/index.php">Home</a>
        <a href="/final_restaurant_project/restaurants.php">Restaurants</a>
        <a href="/final_restaurant_project/gallery.php">Gallery</a>
        <a href="/final_restaurant_project/cart.php">
          Cart <?php 
          $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; 
          if($cart_count > 0): ?>
            <span class="cart-badge"><?php echo $cart_count; ?></span>
          <?php endif; ?>
        </a>
        <?php if(isset($_SESSION['customer_id'])): ?>
          <a href="/final_restaurant_project/orders/my_orders.php">My Orders</a>
          <a href="/final_restaurant_project/reservation/my_reservations.php">My Reservations</a>
        <?php endif; ?>
      </div>

      <!-- Right Auth Links -->
      <div style="margin-left:auto; display:flex; gap:15px; align-items:center;">
        <?php if(isset($_SESSION['customer_id'])): ?>
          <a href="/final_restaurant_project/auth/logout.php">Logout</a>
        <?php else: ?>
          <a href="/final_restaurant_project/auth/login.php">Login</a>
          <a href="/final_restaurant_project/auth/register.php">Sign In</a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

<main>
<div class="wrap container">
<!-- Page content goes here -->
