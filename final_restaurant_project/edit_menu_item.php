<?php
session_start();
include '../db.php';

// Check if user is admin
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit;
}

// Get ID from URL
$id = (int)$_GET['id'];

// Fetch existing data
$stmt = mysqli_prepare($conn, "SELECT mi.*, r.name as restaurant_name FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id WHERE mi.item_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    die("Menu item not found!");
}

$message = "";
$message_type = "";

// When form submitted
if(isset($_POST['submit'])) {
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];

    // Validation
    $errors = [];
    if(empty($item_name)) $errors[] = "Item name is required";
    if($price <= 0) $errors[] = "Price must be greater than 0";

    // Handle image upload
    $image_name = $data['image']; // Keep existing image by default
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        if(!in_array($file_type, $allowed_types)) {
            $errors[] = "Only JPG, PNG, GIF, and WebP images are allowed";
        } elseif($file_size > 5 * 1024 * 1024) { // 5MB limit
            $errors[] = "Image size must be less than 5MB";
        } else {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_path = '../assets/images/menu/' . $image_name;

            // Create directory if it doesn't exist
            if(!is_dir('../assets/images/menu/')) {
                mkdir('../assets/images/menu/', 0777, true);
            }

            if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if it exists and is different
                if($data['image'] && $data['image'] !== $image_name && file_exists('../assets/images/menu/' . $data['image'])) {
                    unlink('../assets/images/menu/' . $data['image']);
                }
            } else {
                $errors[] = "Failed to upload image";
            }
        }
    }

    // If no errors, update database
    if(empty($errors)) {
        $stmt = mysqli_prepare($conn, "UPDATE menu_item SET item_name=?, description=?, price=?, image=? WHERE item_id=?");
        mysqli_stmt_bind_param($stmt, "ssdsi", $item_name, $description, $price, $image_name, $id);

        if(mysqli_stmt_execute($stmt)) {
            $message = "Menu item updated successfully!";
            $message_type = "success";
            // Refresh data
            mysqli_stmt_close($stmt);
            $stmt = mysqli_prepare($conn, "SELECT mi.*, r.name as restaurant_name FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id WHERE mi.item_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = implode("<br>", $errors);
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item - FoodieHub Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-dashboard{max-width:800px;margin:0 auto;padding:20px}
        .dashboard-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
        .admin-nav{background:#f8f9fa;padding:15px;border-radius:8px;margin-bottom:20px;display:flex;gap:8px;flex-wrap:wrap}
        .admin-nav a{background:linear-gradient(135deg, rgba(102,126,234,0.8), rgba(118,75,162,0.8));color:#fff;text-decoration:none;padding:10px 18px;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.1);box-shadow:0 2px 8px rgba(0,0,0,0.1)}
        .admin-nav a::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.2),transparent);transition:left 0.5s ease}
        .admin-nav a:hover{background:linear-gradient(135deg, #667eea, #764ba2);transform:translateY(-2px);box-shadow:0 6px 20px rgba(102,126,234,0.3);border-color:rgba(255,255,255,0.3)}
        .admin-nav a:hover::before{left:100%}
        .admin-nav a:focus{outline:none;box-shadow:0 0 0 3px rgba(102,126,234,0.5)}
        .admin-nav a:active{transform:translateY(0);box-shadow:0 2px 8px rgba(0,0,0,0.1)}
        .form-container{background:#fff;padding:30px;border-radius:10px;box-shadow:0 3px 15px rgba(0,0,0,0.1)}
        .form-container h2{margin-bottom:25px;color:#333;text-align:center}
        .form-group{margin-bottom:20px}
        .form-group label{display:block;margin-bottom:5px;font-weight:600;color:#333}
        .form-group input,.form-group textarea,.form-group select{width:100%;padding:12px;border:2px solid #e1e5e9;border-radius:8px;font-size:14px}
        .form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:#667eea;outline:none}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .form-row .form-group{margin-bottom:0}
        .current-image{display:block;margin:10px 0;padding:10px;border:2px solid #e1e5e9;border-radius:8px;text-align:center;background:#f8f9fa}
        .current-image img{max-width:150px;max-height:150px;border-radius:8px;object-fit:cover}
        .btn-submit{background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#fff;border:none;padding:15px 30px;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;width:100%;margin-top:10px}
        .btn-submit:hover{background:linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%)}
        .message{padding:15px;border-radius:8px;margin-bottom:20px;text-align:center}
        .message.success{background:#d4edda;color:#155724;border:1px solid #c3e6cb}
        .message.error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
        .back-link{display:inline-block;margin-top:20px;padding:10px 20px;background:#6c757d;color:#fff;text-decoration:none;border-radius:6px}
        .back-link:hover{background:#5a6268}
        .restaurant-info{background:#e3f2fd;padding:15px;border-radius:8px;margin-bottom:20px;border-left:4px solid #2196f3}
        .restaurant-info strong{color:#1976d2}
        @media(max-width:768px){.admin-dashboard{max-width:95%}.form-row{grid-template-columns:1fr}}
    </style>
</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Edit Menu Item</h1>
        <a href="../index.php" style="color:#666;text-decoration:none;">← Back to Site</a>
    </div>

    <nav class="admin-nav">
        <a href="index.php">Dashboard</a>
        <a href="manage_orders.php">Orders</a>
        <a href="add_restaurant.php">Add Restaurant</a>
        <a href="add_food.php">Add Menu Item</a>
        <a href="restaurant.php">View Restaurants</a>
    </nav>

    <div class="form-container">
        <h2>Edit Menu Item</h2>

        <?php if($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="restaurant-info">
            <strong>Restaurant:</strong> <?php echo htmlspecialchars($data['restaurant_name']); ?> (ID: <?php echo $data['restaurant_id']; ?>)
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item_name">Item Name *</label>
                <input type="text" id="item_name" name="item_name" value="<?php echo htmlspecialchars($data['item_name']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (₹) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($data['price']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="image">Update Image (optional)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($data['description']); ?></textarea>
            </div>

            <?php if($data['image']): ?>
            <div class="current-image">
                <label>Current Image:</label>
                <img src="../assets/images/menu/<?php echo htmlspecialchars($data['image']); ?>" alt="Current item image">
                <p><small>Leave file input empty to keep current image</small></p>
            </div>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn-submit">Update Menu Item</button>
        </form>

        <div style="text-align:center;margin-top:20px;">
            <a href="index.php" class="back-link">← Back to Admin Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
