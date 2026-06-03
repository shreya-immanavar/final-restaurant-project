<?php include '../header.php'; ?>

<?php
if(!isset($_SESSION['customer_id'])){
    header("Location: " . BASE_URL . "auth/login.php");
    exit;
}

$customer_id = $_SESSION['customer_id'];
$stmt = mysqli_prepare($conn,
    "SELECT r.*, res.name AS restaurant_name, res.location
     FROM reservation r
     INNER JOIN restaurant res ON res.restaurant_id = r.restaurant_id
     WHERE customer_id = ?
     ORDER BY r.r_date DESC, r.r_time DESC"
);
mysqli_stmt_bind_param($stmt, "i", $customer_id);
mysqli_stmt_execute($stmt);
$reservations = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>



<section class="my-reservations">
    <div class="wrap">
        <h1>My Reservations</h1>
        <p>View and manage your table reservations</p>

        <?php if(mysqli_num_rows($reservations) > 0): ?>
            <div class="reservations-list">
                <?php while($reservation = mysqli_fetch_assoc($reservations)): ?>
                <div class="reservation-card">
                    <div class="reservation-header">
                        <h3><?php echo htmlspecialchars($reservation['restaurant_name']); ?></h3>
                        <span class="status-badge status-<?php echo strtolower($reservation['status']); ?>">
                            <?php echo htmlspecialchars($reservation['status']); ?>
                        </span>
                    </div>
                    <div class="reservation-details">
                        <div class="detail-item">
                            <strong>📍 Location:</strong> <?php echo htmlspecialchars($reservation['location']); ?>
                        </div>
                        <div class="detail-item">
                            <strong>📅 Date:</strong> <?php echo date('F j, Y', strtotime($reservation['r_date'])); ?>
                        </div>
                        <div class="detail-item">
                            <strong>🕐 Time:</strong> <?php echo date('g:i A', strtotime($reservation['r_time'])); ?>
                        </div>
                        <div class="detail-item">
                            <strong>👥 People:</strong> <?php echo $reservation['people']; ?>
                        </div>
                    </div>
                    <div class="reservation-actions">
                        <small>Reservation #<?php echo str_pad($reservation['reservation_id'], 6, "0", STR_PAD_LEFT); ?></small>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-reservations">
                <h2>No reservations found</h2>
                <p>You haven't made any reservations yet.</p>
                <a href="<?php echo BASE_URL; ?>reservation/book.php" class="btn btn-primary">Make a Reservation</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include '../footer.php'; ?>
