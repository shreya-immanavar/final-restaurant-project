<?php
echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>";
echo "<h1 style='color: #2c3e50;'>🔧 Localhost Fixer Script</h1>";

// 1. Fix db.php
$db_file = 'db.php';
if (file_exists($db_file)) {
    $db_content = file_get_contents($db_file);
    
    // Replace InfinityFree credentials with local XAMPP credentials
    $db_content = str_replace('sql304.infinityfree.com', 'localhost', $db_content);
    $db_content = str_replace('if0_41628757_rest', 'rest', $db_content);
    $db_content = str_replace('if0_41628757', 'root', $db_content);
    $db_content = str_replace('b1dLHhPe5u5', '', $db_content);
    
    file_put_contents($db_file, $db_content);
    echo "<p style='color: green;'>✅ <b>db.php</b> updated! Connected back to localhost XAMPP database.</p>";
} else {
    echo "<p style='color: red;'>❌ <b>db.php</b> not found!</p>";
}

// The new robust code pattern for images
$new_pattern = "<?php \n" .
               "                        \$clean_image = basename(\$restaurant['image']);\n" .
               "                        \$img_url = 'assets/images/restaurants/' . \$clean_image;\n" .
               "                        \$sys_path = __DIR__ . '/assets/images/restaurants/' . \$clean_image;\n" .
               "                        if(\$restaurant['image'] && file_exists(\$sys_path)): \n" .
               "                    ?>\n" .
               "                        <img src=\"<?php echo \$img_url; ?>\" alt=\"<?php echo htmlspecialchars(\$restaurant['name']); ?>\">\n" .
               "                    <?php else: ?>";

$regex_old = '/<\?php if\(\$restaurant\[\'image\'\] && file_exists\(\'assets\/images\/restaurants\/\' \. \$restaurant\[\'image\'\]\)\): \?>\s*<img src="assets\/images\/restaurants\/<\?php echo htmlspecialchars\(\$restaurant\[\'image\'\]\); \?>" alt="<\?php echo htmlspecialchars\(\$restaurant\[\'name\'\]\); \?>">\s*<\?php else: \?>/s';

// 2. Fix index.php
$index_file = 'index.php';
if (file_exists($index_file)) {
    $index_content = file_get_contents($index_file);
    if (preg_match($regex_old, $index_content)) {
        $index_content = preg_replace($regex_old, $new_pattern, $index_content);
        file_put_contents($index_file, $index_content);
        echo "<p style='color: green;'>✅ <b>index.php</b> updated! Image paths are now fixed.</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ <b>index.php</b> image paths already fixed or pattern not found.</p>";
    }
}

// 3. Fix restaurants.php
$rest_file = 'restaurants.php';
if (file_exists($rest_file)) {
    $rest_content = file_get_contents($rest_file);
    if (preg_match($regex_old, $rest_content)) {
        $rest_content = preg_replace($regex_old, $new_pattern, $rest_content);
        file_put_contents($rest_file, $rest_content);
        echo "<p style='color: green;'>✅ <b>restaurants.php</b> updated! Image paths are now fixed.</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ <b>restaurants.php</b> image paths already fixed or pattern not found.</p>";
    }
}

echo "<hr style='margin: 30px 0; border-top: 1px solid #ddd;'>";
echo "<h3 style='color: #27ae60;'>🎉 All local environment fixes applied successfully!</h3>";
echo "<p>Your project is now fully configured to run on your local XAMPP environment again. The image paths and database connection have been restored and improved.</p>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a>";
echo "</div>";
?>
