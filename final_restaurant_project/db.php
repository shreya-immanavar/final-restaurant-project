<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "sql304.infinityfree.com";
$username   = "if0_41628757";
$password   = "b1dLHhPe5u5"; // put your real password
$dbname     = "if0_41628757_rest";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>