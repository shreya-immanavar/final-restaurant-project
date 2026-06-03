<?php
// Quick database setup - runs the entire SQL file at once
echo "<h1>⚡ Quick Database Setup</h1>";
echo "<pre>";

// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'rest';

// Connect and create database
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected to MySQL\n";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `$db_name`";
if (!mysqli_query($conn, $sql)) {
    die("❌ Database creation failed: " . mysqli_error($conn));
}
echo "✅ Database '$db_name' ready\n";

// Select database
mysqli_select_db($conn, $db_name);

// Run the entire SQL file
$sql_file = 'rest.sql';
if (!file_exists($sql_file)) {
    die("❌ SQL file not found");
}

$sql = file_get_contents($sql_file);
$statements = explode(';', $sql);

$success = 0;
$errors = 0;

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement) && !preg_match('/^--/', $statement)) {
        if (mysqli_query($conn, $statement)) {
            $success++;
        } else {
            $errors++;
            echo "⚠️ Error: " . mysqli_error($conn) . "\n";
        }
    }
}

echo "✅ $success statements executed successfully\n";
if ($errors > 0) {
    echo "⚠️ $errors errors (usually non-critical)\n";
}

mysqli_close($conn);

echo "\n🎉 Setup complete! Visit: <a href='test.php'>Test Page</a> | <a href='index.php'>Homepage</a>\n";
echo "</pre>";
?>


