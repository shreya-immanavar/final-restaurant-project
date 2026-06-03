CREATE DATABASE IF NOT EXISTS rest;
USE rest;

CREATE TABLE customers (
  customer_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  phone VARCHAR(20),
  address TEXT
);

CREATE TABLE restaurant (
  restaurant_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  location VARCHAR(255),
  image VARCHAR(255)
);

CREATE TABLE menu_item (
  item_id INT AUTO_INCREMENT PRIMARY KEY,
  restaurant_id INT,
  item_name VARCHAR(150),
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(255),
  FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id) ON DELETE CASCADE
);

CREATE TABLE reservation (
  reservation_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  restaurant_id INT,
  r_date DATE,
  r_time TIME,
  people INT,
  status VARCHAR(50) DEFAULT 'Booked',
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
  FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id)
);

CREATE TABLE orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  restaurant_id INT,
  total_amount DECIMAL(10,2),
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(50) DEFAULT 'Placed',
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
  FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id)
);

CREATE TABLE order_item (
  oi_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  item_id INT,
  qty INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES menu_item(item_id) ON DELETE CASCADE
);

CREATE TABLE delivery (
  delivery_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  status VARCHAR(50) DEFAULT 'Preparing',
  delivered_at TIMESTAMP NULL,
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

CREATE TABLE payment (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  amount DECIMAL(10,2),
  method VARCHAR(50) DEFAULT 'Cash',
  status VARCHAR(50) DEFAULT 'Paid',
  pay_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- sample data
INSERT INTO restaurant (name, location, image) VALUES
('Pizza Palace', 'MG Road', 'restaurants/pizza.jpg'),
('Burger House', 'City Center', 'restaurants/burger.jpg');

INSERT INTO menu_item (restaurant_id, item_name, description, price, image) VALUES
(1, 'Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella cheese, and fresh basil', 250.00, 'food/p1.jpg'),
(1, 'Veg Loaded Pizza', 'Loaded with bell peppers, onions, mushrooms, olives, and extra cheese', 320.00, 'food/p2.jpg'),
(2, 'Cheese Burger', 'Juicy beef patty with melted cheese, lettuce, tomato, and special sauce', 150.00, 'food/b1.jpg'),
(2, 'Veg Burger', 'Plant-based patty with lettuce, tomato, onion, and vegan mayo', 120.00, 'food/b2.jpg');
