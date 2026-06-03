<?php
include 'auth_check.php';
include '../db.php';

// Fetch all reservations with customer + restaurant info
$query = "
    SELECT 
        r.reservation_id,
        c.name AS customer_name,
        res.name AS restaurant_name,
        r.r_date,
        r.r_time,
        r.people,
        r.status
    FROM reservation r
    INNER JOIN customers c ON c.customer_id = r.customer_id
    INNER JOIN restaurant res ON res.restaurant_id = r.restaurant_id
    ORDER BY r.r_date DESC, r.r_time DESC
";

$reservations = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservations Management - FoodieHub Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Reservations Management</h1>
        <a href="../index.php" class="back-to-site-btn">← Back to Main Site</a>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Orders</a>
        <a href="restaurant.php">Restaurants</a>
        <a href="menu.php">Menu Items</a>
        <a href="add_restaurant.php">Add Restaurant</a>
        <a href="add_food.php">Add Menu Item</a>
        <a href="reservations.php">Reservations</a>
    </nav>

    <div class="content-header">
        <h2>All Reservations</h2>
    </div>

    <?php if(mysqli_num_rows($reservations) > 0): ?>
  <table class="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Restaurant</th>
                <th>Date</th>
                <th>Time</th>
                <th>People</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($reservations)): ?>
            <tr>
                <td><?= $row['reservation_id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= htmlspecialchars($row['restaurant_name']) ?></td>
                <td><?= $row['r_date'] ?></td>
                <td><?= date('g:i A', strtotime($row['r_time'])) ?></td>
                <td><?= $row['people'] ?></td>
                <td><span class="status-badge status-<?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                <td>
                    <div class="action-links">
                        <a class="btn-small btn-update" href="reservation_edit.php?id=<?= $row['reservation_id'] ?>">Edit</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="no-restaurants">
            <h3>No Reservations Found</h3>
            <p>There are currently no reservations made.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
