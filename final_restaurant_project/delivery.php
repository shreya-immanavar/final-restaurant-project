<?php
include 'db.php';

// For demo, we assume admin is logged in

// Update delivery status
if(isset($_GET['deliver_id'])) {
    $delivery_id = $_GET['deliver_id'];
    mysqli_query($conn, "UPDATE delivery SET status='delivered' WHERE delivery_id='$delivery_id'");
    header("Location: delivery.php");
}

// Fetch deliveries
$deliveries = mysqli_query($conn, "SELECT d.delivery_id, d.delivery_address, d.delivery_time, d.status, o.order_id, u.name as customer_name
                                  FROM delivery d
                                  JOIN orders o ON d.order_id=o.order_id
                                  JOIN users u ON o.user_id=u.user_id
                                  ORDER BY d.delivery_time DESC");
?>

<h2>Delivery Management</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Delivery ID</th>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Address</th>
        <th>Delivery Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($deliveries)) { ?>
    <tr>
        <td><?php echo $row['delivery_id']; ?></td>
        <td><?php echo $row['order_id']; ?></td>
        <td><?php echo $row['customer_name']; ?></td>
        <td><?php echo $row['delivery_address']; ?></td>
        <td><?php echo $row['delivery_time']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
            <?php if($row['status'] != 'delivered') { ?>
                <a href="delivery.php?deliver_id=<?php echo $row['delivery_id']; ?>">Mark as Delivered</a>
            <?php } else { echo "Delivered"; } ?>
        </td>
    </tr>
    <?php } ?>
</table>
