<?php
session_start();

// If already logged in as admin, redirect to dashboard
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$message = "";
$message_type = "";

if(isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Simple admin credentials (in production, use database)
    if($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_id'] = 1; // Default admin ID

        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid admin credentials!";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FoodieHub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-login-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .admin-login-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .admin-login-header {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            color: #fff;
            padding: 40px 40px 30px;
            text-align: center;
        }
        .admin-login-header h1 {
            margin: 0 0 10px 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        .admin-login-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 1.1em;
        }
        .admin-login-form {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102,126,234,0.3);
        }
        .login-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.5);
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        .message.error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .admin-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b, #ee4266);
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        @media(max-width:480px) {
            .admin-login-section {
                padding: 10px;
            }
            .admin-login-container {
                max-width: 100%;
            }
            .admin-login-header,
            .admin-login-form {
                padding: 30px 20px;
            }
            .admin-login-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>

<section class="admin-login-section">
    <div class="admin-login-container">
        <div class="admin-login-header">
            <span class="admin-badge">Admin Access</span>
            <h1>FoodieHub</h1>
            <p>Administrator Login</p>
        </div>

        <form method="POST" class="admin-login-form">
            <?php if($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter admin username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter admin password">
            </div>

            <button type="submit" name="login" class="login-btn">Access Admin Panel</button>
        </form>
    </div>
</section>

</body>
</html>
