<?php
include 'auth_check.php';
include '../db.php';

// Handle delete request
if(isset($_GET['delete']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Get image name for deletion
    $stmt = mysqli_prepare($conn, "SELECT image FROM menu_item WHERE item_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if($item) {
        // Delete from database
        $stmt = mysqli_prepare($conn, "DELETE FROM menu_item WHERE item_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Delete image file if exists
        if($item['image'] && file_exists('../assets/images/menu/' . $item['image'])) {
            unlink('../assets/images/menu/' . $item['image']);
        }

        $message = "Menu item deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Menu item not found!";
        $message_type = "error";
    }
}

// Get all menu items with restaurant info
$query = "SELECT mi.*, r.name as restaurant_name FROM menu_item mi
          JOIN restaurant r ON mi.restaurant_id = r.restaurant_id
          ORDER BY mi.item_id DESC";
$menu_items = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items - FoodieHub Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-dashboard{max-width:1200px;margin:0 auto;padding:20px}
        .dashboard-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
        .admin-nav{background:#f8f9fa;padding:15px;border-radius:8px;margin-bottom:20px;display:flex;gap:8px;flex-wrap:wrap}
        .admin-nav a{background:linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));color:#fff;text-decoration:none;padding:10px 18px;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.1);box-shadow:0 2px 8px rgba(0,0,0,0.1)}
        .admin-nav a::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.2),transparent);transition:left 0.5s ease}
        .admin-nav a:hover{background:linear-gradient(135deg, #667eea, #764ba2);transform:translateY(-2px);box-shadow:0 6px 20px rgba(102,126,234,0.3);border-color:rgba(255,255,255,0.3)}
        .admin-nav a:hover::before{left:100%}
        .admin-nav a:focus{outline:none;box-shadow:0 0 0 3px rgba(102,126,234,0.5)}
        .admin-nav a:active{transform:translateY(0);box-shadow:0 2px 8px rgba(0,0,0,0.1)}

        .content-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
        .content-header h2{margin:0;color:#333}
        .add-btn{background:linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));color:#fff !important;text-decoration:none !important;padding:12px 24px;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.2);box-shadow:0 4px 15px rgba(40,167,69,0.3)}
        .add-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);transition:left 0.5s ease}
        .add-btn:hover{background:linear-gradient(135deg, #28a745, #20c997);color:#fff !important;text-decoration:none !important;transform:translateY(-3px);box-shadow:0 8px 25px rgba(40,167,69,0.4);border-color:rgba(255,255,255,0.4)}
        .add-btn:hover::before{left:100%}

        .message{padding:15px;border-radius:8px;margin-bottom:20px;text-align:center}
        .message.success{background:#d4edda;color:#155724;border:1px solid #c3e6cb}
        .message.error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}

        .menu-table{width:100%;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 3px 15px rgba(0,0,0,0.1);border-collapse:collapse}
        .menu-table th,.menu-table td{padding:15px;text-align:left;border-bottom:1px solid #eee}
        .menu-table th{background:linear-gradient(135deg, #f8f9fa, #e9ecef);color:#333;font-weight:600;border-bottom:2px solid #dee2e6}
        .menu-table tr:hover{background:#f8f9fa}
        .menu-table tr:last-child td{border-bottom:none}

        .item-image{width:60px;height:60px;border-radius:8px;object-fit:cover;border:2px solid #e9ecef}
        .item-name{font-weight:600;color:#333}
        .restaurant-badge{display:inline-block;background:linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));color:#fff;padding:4px 8px;border-radius:12px;font-size:11px;font-weight:500;margin-top:4px}
        .price-tag{font-weight:700;color:#28a745;font-size:16px}
        .description-preview{color:#666;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}

        .action-buttons{display:flex;gap:8px}
        .btn-edit{background:linear-gradient(135deg, rgba(255,193,7,0.9), rgba(255,107,107,0.9));color:#fff !important;text-decoration:none !important;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:500;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.2)}
        .btn-edit:hover{background:linear-gradient(135deg, #ffc107, #ff6b6b);color:#fff !important;text-decoration:none !important;transform:translateY(-1px)}
        .btn-delete{background:linear-gradient(135deg, rgba(220,53,69,0.9), rgba(253,126,20,0.9));color:#fff !important;text-decoration:none !important;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:500;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.2)}
        .btn-delete:hover{background:linear-gradient(135deg, #dc3545, #fd7e14);color:#fff !important;text-decoration:none !important;transform:translateY(-1px)}

        .no-items{text-align:center;padding:60px;color:#666}
        .no-items h3{margin-bottom:15px;color:#333}
        .no-items p{margin-bottom:20px}

        .back-to-site-btn{display:inline-block;padding:12px 24px;background:linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));color:#fff !important;text-decoration:none !important;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.2);box-shadow:0 4px 15px rgba(40,167,69,0.3);margin-top:20px}
        .back-to-site-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);transition:left 0.5s ease}
        .back-to-site-btn:hover{background:linear-gradient(135deg, #28a745, #20c997);color:#fff !important;text-decoration:none !important;transform:translateY(-3px);box-shadow:0 8px 25px rgba(40,167,69,0.4);border-color:rgba(255,255,255,0.4)}
        .back-to-site-btn:hover::before{left:100%}
        .back-to-site-btn:focus{outline:none;box-shadow:0 0 0 4px rgba(40,167,69,0.3)}
        .back-to-site-btn:active{transform:translateY(-1px);box-shadow:0 4px 15px rgba(40,167,69,0.2)}

        @media(max-width:768px){
            .admin-dashboard{max-width:95%}
            .content-header{flex-direction:column;gap:15px;text-align:center}
            .menu-table{font-size:14px}
            .menu-table th,.menu-table td{padding:10px}
            .action-buttons{flex-direction:column;gap:4px}
            .btn-edit,.btn-delete{padding:8px 12px;font-size:11px}
        }
    </style>
</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Menu Items Management</h1>
        <a href="../index.php" class="back-to-site-btn">← Back to Main Site</a>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Orders</a>
        <a href="restaurant.php">Restaurants</a>
        <a href="menu.php">Menu Items</a>
        <a href="add_food.php">Add Item</a>
    </nav>

    <div class="content-header">
        <h2>All Menu Items</h2>
        <a href="add_food.php" class="add-btn">+ Add New Item</a>
    </div>

    <?php if(isset($message)): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if(mysqli_num_rows($menu_items) > 0): ?>
        <table class="menu-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item Details</th>
                    <th>Restaurant</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($menu_items)): ?>
                <tr>
                    <td>
                        <?php if($item['image'] && file_exists('../assets/images/menu/' . $item['image'])): ?>
                            <img src="../assets/images/menu/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" class="item-image">
                        <?php else: ?>
                            <div class="item-image" style="background:#f8f9fa;display:flex;align-items:center;justify-content:center;color:#666;font-size:20px;">🍽️</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="item-name"><?php echo htmlspecialchars($item['item_name']); ?></div>
                        <div style="color:#666;font-size:12px;margin-top:2px;">ID: <?php echo $item['item_id']; ?></div>
                    </td>
                    <td>
                        <span class="restaurant-badge"><?php echo htmlspecialchars($item['restaurant_name']); ?></span>
                    </td>
                    <td>
                        <span class="price-tag">₹<?php echo number_format($item['price'], 2); ?></span>
                    </td>
                    <td>
                        <div class="description-preview" title="<?php echo htmlspecialchars($item['description']); ?>">
                            <?php echo htmlspecialchars(substr($item['description'], 0, 50)); ?><?php echo strlen($item['description']) > 50 ? '...' : ''; ?>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="edit_menu_item.php?id=<?php echo $item['item_id']; ?>" class="btn-edit">Edit</a>
                            <a href="?delete=1&id=<?php echo $item['item_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this menu item?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-items">
            <h3>No Menu Items Found</h3>
            <p>You haven't added any menu items yet. Start by adding your first item!</p>
            <a href="add_food.php" class="add-btn">Add First Menu Item</a>
        </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:30px;">
        <a href="index.php" class="back-to-site-btn">← Back to Admin Dashboard</a>
    </div>
</div>

</body>
</html>
