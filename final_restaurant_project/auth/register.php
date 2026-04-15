<?php include '../header.php'; ?>

<?php
$message = "";

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email exists
    $stmt = mysqli_prepare($conn, "SELECT customer_id FROM customers WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        $message = "Email already registered!";
    } else {
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($conn, "INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $pass);

        if(mysqli_stmt_execute($stmt)){
            $message = "Registration Successful! Please login.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>

<style>
.auth-section{background:linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);padding:60px 0;min-height:70vh;display:flex;align-items:center;}
.auth-container{max-width:450px;margin:0 auto;}
.auth-card{background:#fff;border-radius:15px;box-shadow:0 10px 30px rgba(0,0,0,0.1);overflow:hidden;}
.auth-header{text-align:center;padding:40px 40px 20px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#fff;}
.auth-header h1{margin:0 0 10px 0;font-size:2em;font-weight:300;}
.auth-header p{margin:0;opacity:0.9;}
.auth-form{padding:40px;}
.form-group{margin-bottom:25px;}
.form-group label{display:block;margin-bottom:8px;font-weight:600;color:#333;}
.form-group input{width:100%;padding:15px;border:2px solid #e1e5e9;border-radius:8px;font-size:16px;}
.form-group input:focus{border-color:#667eea;outline:none;}
.btn-full{width:100%;padding:15px;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#fff;border:none;border-radius:8px;font-size:16px;font-weight:500;cursor:pointer;margin-top:10px;}
.btn-full:hover{background:linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);}
.auth-footer{text-align:center;padding:30px 40px 40px;border-top:1px solid #f0f0f0;background:#fafbfc;}
.auth-footer p{margin:8px 0;}
.auth-footer a{color:#667eea;text-decoration:none;font-weight:500;}
.alert{padding:15px;border-radius:8px;margin-bottom:20px;text-align:center;font-weight:500;}
.alert-error{background:#fee;color:#c33;border:1px solid #fcc;}
.alert-success{background:#efe;color:#363;border:1px solid #cfc;}
@media(max-width:480px){.auth-section{padding:40px 0;}.auth-container{max-width:95%;padding:0 20px;}.auth-card{border-radius:10px;}.auth-header,.auth-form,.auth-footer{padding:30px 20px;}}
</style>

<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Join FoodieHub</h1>
                <p>Create your account to start ordering delicious food</p>
            </div>

            <?php if($message): ?>
                <div class="alert <?php echo strpos($message, 'Successful') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password" minlength="6">
                </div>

                <button type="submit" name="register" class="btn-full">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Sign in here</a></p>
                <p><a href="../index.php">← Back to Home</a></p>
            </div>
        </div>
    </div>
</section>

<?php include '../footer.php'; ?>
