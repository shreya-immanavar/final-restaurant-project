<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Local XAMPP Database Credentials
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "rest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!defined('BASE_URL')) {
    $doc_root = strtolower(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']));
    $script_dir = strtolower(str_replace('\\', '/', dirname(__FILE__)));
    
    $base_path = '';
    if (strpos($script_dir, $doc_root) === 0) {
        $base_path = substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
    } else {
        $base_path = '/final_restaurant_project/final_restaurant_project/';
    }
    
    $base_path = str_replace('\\', '/', $base_path);
    if (substr($base_path, 0, 1) !== '/') {
        $base_path = '/' . $base_path;
    }
    if (substr($base_path, -1) !== '/') {
        $base_path = $base_path . '/';
    }
    define('BASE_URL', $base_path);
}
?>