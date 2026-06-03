<?php
if (session_status() === PHP_SESSION_NONE) {
    // Configure session settings
    ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes
    ini_set('session.gc_maxlifetime', 3600); // Session expires after 1 hour of inactivity
    session_start();
}

// Check if admin is logged in (check both admin_logged_in and admin_id for compatibility)
if((!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) && 
   (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id']))) {
    // If accessing admin pages directly, redirect to login
    $current_page = basename($_SERVER['PHP_SELF']);
    if($current_page !== 'login.php') {
        header("Location: login.php");
        exit;
    }
}

// Admin logout functionality
if(isset($_GET['logout'])) {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
