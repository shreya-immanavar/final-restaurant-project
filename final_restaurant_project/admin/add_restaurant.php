<?php
include 'auth_check.php';
include '../db.php';

$message = "";
$message_type = "";

// Handle form submission
if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);

    // Validation
    $errors = [];
    if(empty($name)) $errors[] = "Restaurant name is required";
    if(empty($location)) $errors[] = "Location is required";

    // Handle image upload
    $image_name = "";
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
            $upload_path = '../assets/images/restaurants/' . $image_name;

            // Create directory if it doesn't exist
            if(!is_dir('../assets/images/restaurants/')) {
                mkdir('../assets/images/restaurants/', 0777, true);
            }

            if(!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $errors[] = "Failed to upload image";
            }
        }
    } else {
        $errors[] = "Please select an image";
    }

    // If no errors, insert into database
    if(empty($errors)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO restaurant (name, location, image) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $location, $image_name);

        if(mysqli_stmt_execute($stmt)) {
            $message = "Restaurant added successfully!";
            $message_type = "success";
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
    <title>Add Restaurant - FoodieHub Admin</title>
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
        .back-to-site-btn{display:inline-block;padding:12px 24px;background:linear-gradient(135deg, rgba(40,167,69,0.9), rgba(32,201,151,0.9));color:#fff !important;text-decoration:none !important;border-radius:25px;font-weight:500;font-size:14px;letter-spacing:0.5px;transition:all 0.3s ease;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.2);box-shadow:0 4px 15px rgba(40,167,69,0.3);margin-top:20px}
        .back-to-site-btn::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent);transition:left 0.5s ease}
        .back-to-site-btn:hover{background:linear-gradient(135deg, #28a745, #20c997);color:#fff !important;text-decoration:none !important;transform:translateY(-3px);box-shadow:0 8px 25px rgba(40,167,69,0.4);border-color:rgba(255,255,255,0.4)}
        .back-to-site-btn:hover::before{left:100%}
        .back-to-site-btn:focus{outline:none;box-shadow:0 0 0 4px rgba(40,167,69,0.3)}
        .back-to-site-btn:active{transform:translateY(-1px);box-shadow:0 4px 15px rgba(40,167,69,0.2)}
        .form-container{background:#fff;padding:30px;border-radius:10px;box-shadow:0 3px 15px rgba(0,0,0,0.1)}
        .form-container h2{margin-bottom:25px;color:#333;text-align:center}
        .form-group{margin-bottom:20px}
        .form-group label{display:block;margin-bottom:5px;font-weight:600;color:#333}
        .form-group input{width:100%;padding:12px;border:2px solid #e1e5e9;border-radius:8px;font-size:14px}
        .form-group input:focus{border-color:#667eea;outline:none}
        .file-input{display:block;padding:10px;border:2px dashed #cbd5e0;border-radius:8px;text-align:center;cursor:pointer}
        .file-input:hover{border-color:#667eea}
        .btn-submit{background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#fff;border:none;padding:15px 30px;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;width:100%;margin-top:10px}
        .btn-submit:hover{background:linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%)}
        .message{padding:15px;border-radius:8px;margin-bottom:20px;text-align:center}
        .message.success{background:#d4edda;color:#155724;border:1px solid #c3e6cb}
        .message.error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
        .back-link{display:inline-block;margin-top:20px;padding:10px 20px;background:#6c757d;color:#fff !important;text-decoration:none !important;border-radius:6px}
        .back-link:hover{background:#5a6268;color:#fff !important;text-decoration:none !important}
        @media(max-width:768px){.admin-dashboard{max-width:95%}}
    </style>
</head>
<body>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Add Restaurant</h1>
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

    <div class="form-container">
        <h2>Add New Restaurant</h2>

        <?php if($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Restaurant Name *</label>
                <input type="text" id="name" name="name" required placeholder="e.g., Pizza Palace">
            </div>

            <div class="form-group">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" required placeholder="e.g., MG Road, Downtown">
            </div>

            <div class="form-group">
                <label for="image">Restaurant Image *</label>
                <input type="file" id="image" name="image" accept="image/*" required style="padding:8px;">
            </div>

            <button type="submit" name="submit" class="btn-submit">Add Restaurant</button>
        </form>

        <div style="text-align:center;margin-top:20px;">
            <a href="index.php" class="back-link">← Back to Admin Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
