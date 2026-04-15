<?php include "header.php"; ?>

<h2>Our Menu</h2>
<a href="add_menu_item.php">Add New Menu Item</a>
<br><br>

<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM menu_item");

echo "<table border='1' cellpadding='10'>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Image</th>
<th>Actions</th>
</tr>";

while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td>" . $row['item_id'] . "</td>";
    echo "<td>" . $row['item_name'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td><img src='assets/images/menu/". $row['image'] ."' width='80'></td>";
    echo "<td><a href='edit_menu_item.php?id=".$row['item_id']."'>Edit</a> |
          <a href='delete_menu_item.php?id=".$row['item_id']."'>Delete</a></td>";
    echo "</tr>";
}

echo "</table>";
?>

<?php include "footer.php"; ?>
