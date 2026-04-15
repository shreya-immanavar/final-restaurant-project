<?php
include '../db.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM restaurant WHERE restaurant_id=$id"));

unlink("../uploads/restaurant/" . $data['image']);

mysqli_query($conn, "DELETE FROM restaurant WHERE restaurant_id=$id");

echo "<script>alert('Restaurant Deleted'); window.location='restaurant.php';</script>";
?>
