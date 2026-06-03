<?php
include 'db.php';
$res = mysqli_query($conn, "SELECT name, image FROM restaurant");
while ($r = mysqli_fetch_assoc($res)) {
    echo "Restaurant: " . $r['name'] . "\n";
    echo "DB Image: " . $r['image'] . "\n";
    $path = 'assets/images/restaurants/' . $r['image'];
    echo "Path: " . $path . "\n";
    echo "Exists? " . (file_exists($path) ? "YES" : "NO") . "\n\n";
}
?>
