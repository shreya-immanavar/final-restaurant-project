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
<link rel="stylesheet" href="../assets/css/style.css">
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-dashboard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 2.5em;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .admin-nav {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .admin-nav a {
        background: linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));
        color: #fff !important;
        text-decoration: none !important;
        padding: 10px 18px;
        border-radius: 25px;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .admin-nav a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .admin-nav a:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102,126,234,0.3);
        border-color: rgba(255,255,255,0.3);
        color: #fff !important;
        text-decoration: none !important;
    }

    .admin-nav a:hover::before {
        left: 100%;
    }

    .back-to-site-btn {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));
        color: #fff !important;
        text-decoration: none !important;
        border-radius: 25px;
        font-weight: 500;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 15px rgba(40,167,69,0.3);
    }

    .back-to-site-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .back-to-site-btn:hover {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: #fff !important;
        text-decoration: none !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(40,167,69,0.4);
        border-color: rgba(255,255,255,0.4);
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .content-header h2 {
        margin: 0;
        color: #2d3748;
        font-size: 1.8em;
        font-weight: 600;
    }

    .reservations-table {
        width: 100%;
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-collapse: collapse;
    }

    .reservations-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 20px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: none;
    }

    .reservations-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .reservations-table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%);
        transform: scale(1.01);
    }

    .reservations-table tbody td {
        padding: 20px 15px;
        vertical-align: middle;
        color: #2d3748;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        color: #fff;
        text-transform: uppercase;
    }

    .status-Booked { background: #17a2b8; }
    .status-Approved{ background: #28a745; }
    .status-Cancelled { background: #dc3545; }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-edit {
        background: linear-gradient(135deg, rgba(255,193,7,0.9), rgba(255,107,107,0.9));
        color: #fff !important;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none !important;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 3px 8px rgba(255,193,7,0.3);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #ffc107, #ff6b6b);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(255,193,7,0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, rgba(220,53,69,0.9), rgba(253,126,20,0.9));
        color: #fff !important;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none !important;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 3px 8px rgba(220,53,69,0.3);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #dc3545, #fd7e14);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(220,53,69,0.4);
    }

    @media (max-width: 768px) {
        .dashboard-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        .content-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        .reservations-table thead th, .reservations-table tbody td { padding: 12px 10px; }
        .action-buttons { flex-direction: column; gap: 4px; }
    }
</style>
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
    <table class="reservations-table">
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
                    <div class="action-buttons">
                        <a class="btn-edit" href="reservation_edit.php?id=<?= $row['reservation_id'] ?>">Edit</a>
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
