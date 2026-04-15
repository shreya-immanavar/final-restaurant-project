<?php
include '../db.php';

// Initialize variables
$id = $name = $description = $price = $restaurant_id = $image_name = "";

// Check if editing
if(isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu_item WHERE item_id='$id'"));
    $name = $menu['item_name'];
    $description = $menu['description'];
    $price = $menu['price'];
    $restaurant_id = $menu['restaurant_id'];
    $image_name = $menu['image'];
}

// Form submission
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $restaurant_id = $_POST['restaurant_id'];

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = "../assets/images/menu/";

        if(!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($tmp_name, $folder . $image_name);
    }

    // Insert or update
    if($id == "") {
        $sql = "INSERT INTO menu_item (restaurant_id, item_name, description, price, image)
                VALUES ('$restaurant_id', '$name', '$description', '$price', '$image_name')";
        $msg = "Menu Item Added Successfully!";
    } else {
        $sql = "UPDATE menu_item SET restaurant_id='$restaurant_id', item_name='$name', description='$description', price='$price', image='$image_name' WHERE item_id='$id'";
        $msg = "Menu Item Updated Successfully!";
    }

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('$msg'); window.location='menu.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch restaurants for dropdown
$restaurants = mysqli_query($conn, "SELECT * FROM restaurant");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $id ? "Edit" : "Add"; ?> Menu Item</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .form-box { width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, textarea, select { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: green; border: none; padding: 10px 20px; color: white; margin-top: 15px; cursor: pointer; }
        button:hover { background: darkgreen; }
        img { max-width: 150px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="form-box">
    <h2><?php echo $id ? "Edit" : "Add"; ?> Menu Item</h2>
    <form method="POST" enctype="multipart/form-data">

        <label>Restaurant</label>
        <select name="restaurant_id" required>
            <option value="">Select Restaurant</option>
            <?php while($row = mysqli_fetch_assoc($restaurants)) { ?>
                <option value="<?php echo $row['restaurant_id']; ?>" <?php if($row['restaurant_id']==$restaurant_id) echo "selected"; ?>>
                    <?php echo $row['name']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Menu Item Name</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required>

        <label>Description</label>
        <textarea name="description" required><?php echo $description; ?></textarea>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?php echo $price; ?>" required>

        <label>Image</label>
        <input type="file" name="image" <?php echo $id ? "" : "required"; ?>>
        <?php if($image_name) { echo "<br><img src='../assets/images/menu/$image_name' alt='$name'>"; } ?>

        <button type="submit" name="submit"><?php echo $id ? "Update" : "Add"; ?> Item</button>

    </form>
</div>

</body>
</html>
