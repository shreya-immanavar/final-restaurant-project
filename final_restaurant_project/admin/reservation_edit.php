<?php
include 'auth_check.php';
include '../db.php';

$id = $_GET['id'];

// Fetch reservation data
$query = "SELECT * FROM reservation WHERE reservation_id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<p>Reservation not found!</p>";
    exit;
}

// Update reservation status
if (isset($_POST['update'])) {
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE reservation SET status='$status' WHERE reservation_id=$id");

    header("Location: reservations.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation - FoodieHub Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: var(--color-bg); background-image: radial-gradient(at 0% 0%, hsla(43,74%,49%,0.05) 0px, transparent 50%), radial-gradient(at 100% 100%, hsla(40,30%,75%,0.03) 0px, transparent 50%);
            min-height: 100vh;
            font-family: var(--font-sans);
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: var(--color-surface);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-text);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }
        select.form-control {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        /* Buttons Container */
        .form-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
        }

        /* Update Button */
        button.btn-success {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--color-secondary), var(--color-secondary-light)); /* Green gradient */
            color: #fff;
            text-transform: uppercase;
        }
        button.btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
        }

        /* Back Button */
        button.btn-secondary {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #6c757d, #5a6268); /* Gray gradient */
            color: #fff;
            text-transform: uppercase;
        }
        button.btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268, #495057);
        }

        /* Make link inside back button take full size */
        button.btn-secondary a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Reservation</h1>

    <form method="POST">
        <div class="form-group">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="Approved" <?= $data['status']=="Approved" ? "selected" : "" ?>>Approved</option>
                <option value="Cancelled" <?= $data['status']=="Cancelled" ? "selected" : "" ?>>Cancelled</option>
            </select>
        </div>

        <div class="form-buttons">
            <button name="update" class="btn-success">Update</button>
            <button type="button" class="btn-secondary"><a href="reservations.php">Back</a></button>
        </div>
    </form>
</div>

</body>
</html>
