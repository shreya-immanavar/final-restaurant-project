# FoodieHub — Premium Restaurant System 🍔🍕

A complete, feature-rich web application built with PHP and MySQL for managing restaurant menus, customer orders, and table reservations.

## ✨ Features

### Customer Facing
- **Dynamic Restaurant Listings:** Browse through multiple restaurants and view their specific menus.
- **Shopping Cart & Checkout:** Add food items to a shopping cart and place delivery orders.
- **Table Reservations:** Book tables at specific restaurants in advance.
- **User Authentication:** Customers can register, log in, and view their order/reservation history.
- **Beautiful UI:** A modern, premium aesthetic with smooth gradients, responsive design, and CSS micro-animations.

### Admin Dashboard (`/admin/`)
- **Restaurant Management:** Add, edit, or delete restaurants with dedicated image uploads.
- **Menu Management:** Create and edit menu items, set prices, and upload food images.
- **Order Tracking:** View and manage customer orders.
- **Secure Access:** Dedicated admin login and session management to protect backend routes.

## 💻 Tech Stack
- **Frontend:** HTML5, CSS3 (Custom responsive design), Vanilla JavaScript.
- **Backend:** PHP (8.0+)
- **Database:** MySQL
- **Environment:** Designed for local development (XAMPP/WAMP) and ready for shared hosting (e.g., InfinityFree).

---

## 🚀 Installation & Setup (Local XAMPP)

1. **Move to XAMPP:**
   Place the entire project folder (`final_restaurant_project`) inside your XAMPP `htdocs` directory:
   `C:\xampp\htdocs\final_restaurant_project\`

2. **Start Servers:**
   Open the XAMPP Control Panel and start both **Apache** and **MySQL**.

3. **Database Configuration:**
   - Open your browser and navigate to the quick setup script:
     `http://localhost/final_restaurant_project/final_restaurant_project/quick_setup.php`
   - *Alternatively:* You can manually create a database named `rest` in phpMyAdmin and import the `rest.sql` file.

4. **Run the Project:**
   Visit the main site in your browser:
   `http://localhost/final_restaurant_project/final_restaurant_project/index.php`

---

## 🌐 Deploying to Live Hosting (InfinityFree, etc.)

When moving this project to a live server, follow these steps to ensure it works correctly:

1. **Upload Files:** Upload the contents of your project directory directly into the `htdocs` folder of your web host.
2. **Import Database:** Use phpMyAdmin provided by your host to import `rest.sql` manually. *(Scripts like `quick_setup.php` usually do not work on shared hosting due to permission restrictions).*
3. **Update `db.php`:** Open `db.php` and replace the local database credentials with the ones provided by your hosting provider:
   ```php
   $servername = "your_host_address";
   $username   = "your_db_username";
   $password   = "your_db_password";
   $dbname     = "your_db_name";
   ```

