<?php
include 'auth_check.php';
include '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants Management - FoodieHub Admin</title>
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

        .back-to-site-btn:hover::before {
            left: 100%;
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

        .add-btn {
            background: linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));
            color: #fff !important;
            text-decoration: none !important;
            padding: 12px 24px;
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

        .add-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff !important;
            text-decoration: none !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40,167,69,0.4);
            border-color: rgba(255,255,255,0.4);
        }

        .add-btn:hover::before {
            left: 100%;
        }

        .restaurants-table {
            width: 100%;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-collapse: collapse;
        }

        .restaurants-table thead th {
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

        .restaurants-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .restaurants-table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%);
            transform: scale(1.01);
        }

        .restaurants-table tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            color: #2d3748;
        }

        .restaurant-id {
            font-weight: 700;
            color: #28a745;
            font-size: 1rem;
        }

        .restaurant-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2d3748;
        }

        .restaurant-location {
            color: #718096;
            font-size: 0.95rem;
        }

        .restaurant-image {
            width: 100px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            border: 2px solid #f1f5f9;
        }

        .image-placeholder-table {
            width: 100px;
            height: 70px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: #94a3b8;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background: linear-gradient(135deg, rgba(255,193,7,0.9), rgba(255,107,107,0.9));
            color: #fff !important;
            text-decoration: none !important;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 3px 8px rgba(255,193,7,0.3);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #ffc107, #ff6b6b);
            color: #fff !important;
            text-decoration: none !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(255,193,7,0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, rgba(220,53,69,0.9), rgba(253,126,20,0.9));
            color: #fff !important;
            text-decoration: none !important;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 3px 8px rgba(220,53,69,0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: #fff !important;
            text-decoration: none !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(220,53,69,0.4);
        }

        .no-restaurants {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            margin-top: 40px;
            border: 1px solid #e2e8f0;
        }

        .no-restaurants h3 {
            font-size: 1.5rem;
            color: #64748b;
            margin-bottom: 10px;
        }

        .no-restaurants p {
            font-size: 1.1rem;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .dashboard-header h1 {
                font-size: 2em;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .restaurants-table {
                font-size: 0.9rem;
            }

            .restaurants-table thead th,
            .restaurants-table tbody td {
                padding: 12px 10px;
            }

            .restaurant-image,
            .image-placeholder-table {
                width: 60px;
                height: 45px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Restaurants Management</h1>
        <a href="../index.php" class="back-to-site-btn">← Back to Main Site</a>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Orders</a>
        <a href="restaurant.php">Restaurants</a>
        <a href="menu.php">Menu Items</a>
        <a href="add_restaurant.php">Add Restaurant</a>
        <a href="add_food.php">Add Menu Item</a>
    </nav>

    <div class="content-header">
        <h2>All Restaurants</h2>
        <a href="add_restaurant.php" class="add-btn">+ Add New Restaurant</a>
    </div>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM restaurant ORDER BY restaurant_id ASC");
    if (mysqli_num_rows($result) > 0):
    ?>
        <table class="restaurants-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <div class="restaurant-id"><?= $row['restaurant_id'] ?></div>
                    </td>
                    <td>
                        <?php 
                        $image_path = '../assets/images/restaurants/' . $row['image'];
                        if($row['image'] && file_exists($image_path)): 
                        ?>
                            <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="restaurant-image">
                        <?php else: ?>
                            <div class="image-placeholder-table">
                                <span><?= htmlspecialchars(substr($row['name'], 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="restaurant-name"><?= htmlspecialchars($row['name']) ?></div>
                    </td>
                    <td>
                        <div class="restaurant-location"><?= htmlspecialchars($row['location']) ?></div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a class="btn-edit" href="edit_restaurant.php?id=<?= $row['restaurant_id'] ?>">Edit</a>
                            <a class="btn-delete" href="delete_restaurant.php?id=<?= $row['restaurant_id'] ?>" onclick="return confirm('Are you sure you want to delete this restaurant?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-restaurants">
            <h3>No Restaurants Found</h3>
            <p>You haven't added any restaurants yet. Start by adding your first restaurant!</p>
            <a href="add_restaurant.php" class="add-btn" style="margin-top: 20px; display: inline-block;">Add First Restaurant</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
