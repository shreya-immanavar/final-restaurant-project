<?php
include 'db.php';
include 'header.php';

// Initialize variables
$id = $name = $description = $price = $restaurant_id = $image_name = "";

// Check if editing
if(isset($_GET['edit_id'])) {
    $id = (int)$_GET['edit_id'];
    $menu_query = mysqli_query($conn, "SELECT * FROM menu_item WHERE item_id='$id'");
    $menu = mysqli_fetch_assoc($menu_query);
    if ($menu) {
        $name = $menu['item_name'];
        $description = $menu['description'];
        $price = $menu['price'];
        $restaurant_id = $menu['restaurant_id'];
        $image_name = $menu['image'];
    }
}

// Form submission
if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float)$_POST['price'];
    $restaurant_id = (int)$_POST['restaurant_id'];

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = "assets/images/menu/";

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
        echo "<script>alert('$msg'); window.location='" . BASE_URL . "menu.php';</script>";
    } else {
        echo "<div class='alert alert-error' style='max-width:600px; margin:20px auto;'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch restaurants for dropdown
$restaurants = mysqli_query($conn, "SELECT * FROM restaurant ORDER BY name");
?>

<section class="add-menu-section" style="padding: 40px 0;">
    <div class="wrap">
        <div style="max-width: 600px; margin: 0 auto; background: var(--color-surface); padding: 40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid rgba(0,0,0,0.03);">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="font-size: 2.2rem; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight:800;"><?php echo $id ? "Edit" : "Add New"; ?> Menu Item</h2>
                <p style="color:var(--color-text-muted);">Manage your FoodieHub menu offerings</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group" style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:14px;">Select Restaurant *</label>
                    <select name="restaurant_id" required style="width:100%; padding:12px; border:2px solid var(--color-border); border-radius:var(--radius-sm); font-size:14px; font-family:var(--font-sans); background:var(--color-surface);">
                        <option value="">Choose partner restaurant</option>
                        <?php while($row = mysqli_fetch_assoc($restaurants)) { ?>
                            <option value="<?php echo $row['restaurant_id']; ?>" <?php if($row['restaurant_id']==$restaurant_id) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:14px;">Menu Item Name *</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required style="width:100%; padding:12px; border:2px solid var(--color-border); border-radius:var(--radius-sm); font-size:14px; font-family:var(--font-sans);" placeholder="e.g. Double Pepperoni Feast">
                </div>

                <div class="form-group" style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:14px;">Description *</label>
                    <textarea name="description" required style="width:100%; padding:12px; border:2px solid var(--color-border); border-radius:var(--radius-sm); font-size:14px; font-family:var(--font-sans); min-height:100px;" placeholder="Describe ingredients, portion sizes, or allergens..."><?php echo htmlspecialchars($description); ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:14px;">Price (₹) *</label>
                    <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required style="width:100%; padding:12px; border:2px solid var(--color-border); border-radius:var(--radius-sm); font-size:14px; font-family:var(--font-sans);" placeholder="Enter amount in Rupees">
                </div>

                <div class="form-group" style="margin-bottom:25px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:14px;">Menu Item Image <?php echo $id ? "(Optional)" : "*"; ?></label>
                    <input type="file" name="image" <?php echo $id ? "" : "required"; ?> style="width:100%; padding:8px 0; font-size:14px;">
                    
                    <?php if($image_name): ?>
                        <div style="margin-top: 15px; text-align: center; padding: 15px; border: 2px dashed var(--color-border); border-radius: var(--radius-sm);">
                            <span style="display:block; margin-bottom:5px; font-size:12px; color:var(--color-text-muted);">Current Image Preview:</span>
                            <img src="<?php echo BASE_URL . 'assets/images/menu/' . $image_name; ?>" alt="<?php echo $name; ?>" style="max-width:120px; border-radius:var(--radius-sm); box-shadow:var(--shadow-sm);">
                        </div>
                    <?php endif; ?>
                </div>

                <div style="display:flex; gap:15px; align-items:center; margin-top:30px;">
                    <a href="<?php echo BASE_URL; ?>menu.php" class="btn btn-secondary" style="flex:1; text-align:center;">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-primary" style="flex:2;"><?php echo $id ? "⚡ Update" : "➕ Add"; ?> Item</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
