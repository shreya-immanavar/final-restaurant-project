<?php include '../header.php'; ?>

<?php
$message = "";

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM customers WHERE email=? AND password=?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){
        $data = mysqli_fetch_assoc($result);
        $_SESSION['customer_id'] = $data['customer_id'];
        $_SESSION['customer_name'] = $data['name'];
        $_SESSION['customer_email'] = $data['email'];
        header("Location: ../index.php");
        exit;
    } else {
        $message = "Invalid email or password!";
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
@media(max-width:480px){.auth-section{padding:40px 0;}.auth-container{max-width:95%;padding:0 20px;}.auth-card{border-radius:10px;}.auth-header,.auth-form,.auth-footer{padding:30px 20px;}}
</style>

<section class="auth-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your FoodieHub account</p>
            </div>

            <?php if($message): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>

                <button type="submit" name="login" class="btn-full">Sign In</button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Create one here</a></p>
                <p><a href="../index.php">← Back to Home</a></p>
            </div>
        </div>
    </div>
</section>

<?php include '../footer.php'; ?>
