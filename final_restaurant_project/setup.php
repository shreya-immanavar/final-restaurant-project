<?php
// Simple database setup script
echo "<h1>🚀 FoodieHub Database Setup</h1>";
echo "<style>body{font-family:Arial;padding:20px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'rest';

// Connect to MySQL
echo "<h3>Step 1: Connecting to MySQL...</h3>";
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("<p class='error'>❌ FAILED: " . mysqli_connect_error() . "</p><p><a href='test.php'>← Back to Test</a></p>");
}
echo "<p class='success'>✅ Connected successfully</p>";

// Create database
echo "<h3>Step 2: Creating database...</h3>";
$sql = "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (mysqli_query($conn, $sql)) {
    echo "<p class='success'>✅ Database '$db_name' created</p>";
} else {
    die("<p class='error'>❌ FAILED: " . mysqli_error($conn) . "</p>");
}

// Select database
mysqli_select_db($conn, $db_name);

// Read and execute SQL file
echo "<h3>Step 3: Importing tables and data...</h3>";
$sql_file = 'rest.sql';
if (!file_exists($sql_file)) {
    die("<p class='error'>❌ SQL file not found</p>");
}

$sql_content = file_get_contents($sql_file);

// Remove comments and split into statements
$sql_content = preg_replace('/--.*$/m', '', $sql_content); // Remove single line comments
$sql_content = preg_replace('/\/\*.*?\*\//s', '', $sql_content); // Remove multi-line comments

$statements = array_filter(array_map('trim', explode(';', $sql_content)));
$success_count = 0;
$errors = [];

foreach ($statements as $statement) {
    if (!empty($statement)) {
        if (mysqli_query($conn, $statement)) {
            $success_count++;
        } else {
            $errors[] = mysqli_error($conn) . " (SQL: " . substr($statement, 0, 50) . "...)";
        }
    }
}

echo "<p class='success'>✅ Executed $success_count SQL statements</p>";

if (!empty($errors)) {
    echo "<h4>Errors (non-critical):</h4>";
    foreach ($errors as $error) {
        echo "<p class='info'>⚠️ $error</p>";
    }
}

// Test the database
echo "<h3>Step 4: Testing database...</h3>";
$result = mysqli_query($conn, "SHOW TABLES");
$tables = [];
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

echo "<p class='success'>✅ Found " . count($tables) . " tables: " . implode(', ', $tables) . "</p>";

// Test sample data
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM restaurant");
$restaurant_count = mysqli_fetch_assoc($result)['count'];

$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM menu_item");
$menu_count = mysqli_fetch_assoc($result)['count'];

echo "<p class='success'>✅ Sample data: $restaurant_count restaurants, $menu_count menu items</p>";

mysqli_close($conn);

echo "<h2>🎉 Setup Complete!</h2>";
echo "<p class='success'>Your FoodieHub database is ready!</p>";
echo "<p><a href='test.php' class='success'>🧪 Run Tests</a> | <a href='index.php'>🏠 Go to Homepage</a></p>";
?>


