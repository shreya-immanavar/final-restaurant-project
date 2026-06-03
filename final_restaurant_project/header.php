<?php
include_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>FoodieHub — Premium Restaurant System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="site-header">
  <div class="wrap">
    <a class="logo" href="<?php echo BASE_URL; ?>index.php">
        <i class="fa-solid fa-utensils logo-icon"></i>
        <span class="logo-text">FoodieHub</span>
    </a>
    <nav class="main-nav">
      <!-- Left Navigation Links -->
      <div style="display:flex; gap:15px; align-items:center;">
        <a href="<?php echo BASE_URL; ?>index.php">Home</a>
        <a href="<?php echo BASE_URL; ?>restaurants.php">Restaurants</a>
        <a href="<?php echo BASE_URL; ?>gallery.php">Gallery</a>
        <a href="<?php echo BASE_URL; ?>cart.php">
          Cart <?php 
          $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; 
          if($cart_count > 0): ?>
            <span class="cart-badge"><?php echo $cart_count; ?></span>
          <?php endif; ?>
        </a>
        <?php if(isset($_SESSION['customer_id'])): ?>
          <a href="<?php echo BASE_URL; ?>orders/my_orders.php">My Orders</a>
          <a href="<?php echo BASE_URL; ?>reservation/my_reservations.php">My Reservations</a>
        <?php endif; ?>
      </div>

      <!-- Right Auth Links -->
      <div style="margin-left:auto; display:flex; gap:15px; align-items:center;">
        <?php if(isset($_SESSION['customer_id'])): ?>
          <a href="<?php echo BASE_URL; ?>auth/logout.php">Logout</a>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>auth/login.php">Login</a>
          <a href="<?php echo BASE_URL; ?>auth/register.php">Sign In</a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

<main>
<div class="wrap container">
<!-- Page content goes here -->
