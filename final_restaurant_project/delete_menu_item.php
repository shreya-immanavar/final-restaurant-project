
<?php
include '../db.php';

// Get ID from URL
$id = $_GET['id'];

// Fetch the item to get image name
$result = mysqli_query($conn, "SELECT image FROM menu_item WHERE item_id = $id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Menu item not found!");
}

// Image file path
$image_path = "../uploads/menu/" . $data['image'];

// Delete record from DB
$delete_sql = "DELETE FROM menu_item WHERE item_id = $id";

if (mysqli_query($conn, $delete_sql)) {

    // Delete image file
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    echo "<script>alert('Menu Item Deleted Successfully'); window.location='menu.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
