<?php include '../header.php'; ?>

<?php
if(!isset($_SESSION['customer_id'])){
    header("Location: ../auth/login.php");
    exit;
}

$message = "";

if(isset($_POST['reserve'])){
    $customer_id = $_SESSION['customer_id'];
    $restaurant_id = (int)$_POST['restaurant'];
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $people = (int)$_POST['people'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO reservation (customer_id, restaurant_id, r_date, r_time, people)
         VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "iissi",
        $customer_id,
        $restaurant_id,
        $date,
        $time,
        $people
    );

    if(mysqli_stmt_execute($stmt)){
        $message = "Reservation successful! We'll contact you soon to confirm.";
    } else {
        $message = "Something went wrong. Please try again.";
    }
    mysqli_stmt_close($stmt);
}
?>

<section class="reservation-section">
    <div class="wrap">
        <h1>Make a Reservation</h1>
        <p>Book a table at your favorite restaurant</p>

        <?php if($message): ?>
            <div class="message success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="reservation-form-container">
            <form method="POST" class="reservation-form">

                <div class="form-group">
                    <label>Select Restaurant:</label>
                    <select name="restaurant" required>
                        <option value="">Choose a restaurant</option>
                        <?php
                        $restaurants = mysqli_query($conn, "SELECT * FROM restaurant ORDER BY name");
                        while($restaurant = mysqli_fetch_assoc($restaurants)):
                        ?>
                        <option value="<?php echo $restaurant['restaurant_id']; ?>">
                            <?php echo htmlspecialchars($restaurant['name']); ?> -
                            <?php echo htmlspecialchars($restaurant['location']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date"
                               name="date"
                               id="date"
                               required
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Time:</label>
                        <input type="time"
                               name="time"
                               id="time"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Number of People:</label>
                    <input type="number"
                           name="people"
                           min="1"
                           max="20"
                           required>
                </div>

                <button type="submit" name="reserve" class="btn btn-primary">
                    Make Reservation
                </button>

            </form>
        </div>
    </div>
</section>

<!-- ✅ TIME VALIDATION SCRIPT -->
<script>
const dateInput = document.getElementById('date');
const timeInput = document.getElementById('time');

function applyTimeRule() {
    const now = new Date();
    const selectedDate = dateInput.value;
    const today = now.toISOString().split('T')[0];

    if (selectedDate === today) {
        // Always move to NEXT FULL HOUR
        now.setHours(now.getHours() + 1);
        now.setMinutes(0);
        now.setSeconds(0);

        const hour = String(now.getHours()).padStart(2, '0');
        timeInput.min = hour + ":00";
    } else {
        // Future date → all times allowed
        timeInput.min = "00:00";
    }
}

window.addEventListener('load', applyTimeRule);
dateInput.addEventListener('change', applyTimeRule);
</script>

<?php include '../footer.php'; ?>
