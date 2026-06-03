@echo off
echo ====================================
echo FoodieHub Database Import Script
echo ====================================
echo.

cd /d C:\xampp\mysql\bin

echo Creating database 'rest' if it doesn't exist...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS rest;"

echo.
echo Importing tables and data...
mysql -u root rest < C:\xampp\htdocs\final_restaurant_project\rest.sql

echo.
echo Import completed!
echo.
echo Press any key to test the database...
pause > nul

echo.
echo Testing database connection...
mysql -u root rest -e "SHOW TABLES;"

echo.
echo If you see tables listed above, the import was successful!
echo Now visit: http://localhost/final_restaurant_project/
echo.
pause


