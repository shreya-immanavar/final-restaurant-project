<?php
// Database import script for FoodieHub
echo "<h1>FoodieHub Database Import</h1>";

// Database connection details
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'rest';

// Connect to MySQL (without selecting database first)
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("<p style='color: red;'>❌ MySQL Connection Failed: " . mysqli_connect_error() . "</p>");
}

echo "<p style='color: green;'>✅ Connected to MySQL successfully</p>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$db_name`";
if (mysqli_query($conn, $sql)) {
    echo "<p style='color: green;'>✅ Database '$db_name' created or already exists</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating database: " . mysqli_error($conn) . "</p>";
}

// Select the database
mysqli_select_db($conn, $db_name);

// Read the SQL file
$sql_file = 'rest.sql';
if (!file_exists($sql_file)) {
    die("<p style='color: red;'>❌ SQL file '$sql_file' not found</p>");
}

$sql_content = file_get_contents($sql_file);

// Split into individual statements (more robust parsing)
$statements = [];
$current_statement = '';
$in_multiline_comment = false;

$lines = explode("\n", $sql_content);
foreach ($lines as $line) {
    $line = trim($line);

    // Skip empty lines and single line comments
    if (empty($line) || strpos($line, '--') === 0) {
        continue;
    }

    $current_statement .= $line . "\n";

    // If line ends with semicolon, it's a complete statement
    if (substr($line, -1) === ';') {
        $statements[] = trim($current_statement);
        $current_statement = '';
    }
}

$success_count = 0;
$error_count = 0;

echo "<h3>Executing SQL Statements...</h3>";
echo "<div style='max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0;'>";

foreach ($statements as $statement) {
    if (!empty(trim($statement))) {
        if (mysqli_query($conn, $statement)) {
            echo "<p style='color: green; margin: 2px 0;'>✅ Statement executed successfully</p>";
            $success_count++;
        } else {
            $error = mysqli_error($conn);
            echo "<p style='color: red; margin: 2px 0;'>❌ Error: $error</p>";
            echo "<p style='color: orange; font-size: 0.9em; margin: 2px 0;'>SQL: " . substr($statement, 0, 100) . "...</p>";
            $error_count++;
        }
    }
}

echo "</div>";

echo "<h2>Import Results:</h2>";
echo "<p style='color: green;'>✅ Successful statements: $success_count</p>";
if ($error_count > 0) {
    echo "<p style='color: orange;'>⚠️ Errors: $error_count</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<p>1. <a href='index.php'>Go to Homepage</a></p>";
echo "<p>2. <a href='auth/register.php'>Create Admin Account</a></p>";
echo "<p>3. <a href='admin/'>Access Admin Panel</a></p>";

mysqli_close($conn);
?>
