# Property and Vehicle Management System

A simple PHP/MySQL web application for managing property and vehicle rentals. This system allows owners to list properties and vehicles, and customers to browse and reserve them.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Quick Start](#quick-start)
- [Installation Guide](#installation-guide)
  - [Ubuntu/Debian Setup](#ubuntudebian-setup)
  - [Quick Development Server](#quick-development-server)
  - [Windows (XAMPP)](#windows-xampp)
  - [macOS (MAMP)](#macos-mamp)
- [Database Configuration](#database-configuration)
- [Testing Your Setup](#testing-your-setup)
- [Troubleshooting](#troubleshooting)
- [Project Structure](#project-structure)

## ✨ Features

- User authentication (Owner and Customer roles)
- Property management (add, view, reserve properties)
- Vehicle management (add, view, reserve vehicles)
- Rental status tracking
- Dashboard for owners and customers

## 🔧 Requirements

- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache2 (or any web server) or PHP built-in server
- PHP mysqli extension

## 🚀 Quick Start

**For Ubuntu/Debian users** (fastest way to get started):

```bash
# 1. Clone or download the project
git clone https://github.com/yourusername/Property-and-Vehicle-Management-System.git
cd Property-and-Vehicle-Management-System

# 2. Install required packages
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-mysql mysql-server -y

# 3. Start services
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql

# 4. Setup database
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS rent; CREATE USER IF NOT EXISTS 'pvmuser'@'localhost' IDENTIFIED BY 'pvm123'; GRANT ALL PRIVILEGES ON rent.* TO 'pvmuser'@'localhost'; FLUSH PRIVILEGES;"

# 5. Import database schema
mysql -u pvmuser -ppvm123 rent < rental-tables-with-relationships.sql

# 6. Copy project to web directory
sudo cp -r . /var/www/html/Property-and-Vehicle-Management-System
sudo chown -R www-data:www-data /var/www/html/Property-and-Vehicle-Management-System
sudo chmod -R 755 /var/www/html/Property-and-Vehicle-Management-System
sudo systemctl restart apache2

# 7. Open in browser
# Visit: http://localhost/Property-and-Vehicle-Management-System/login.php
```

## 📖 Installation Guide

### Ubuntu/Debian Setup

#### Step 1: Download the Project

```bash
# Option 1: Clone with Git
git clone https://github.com/yourusername/Property-and-Vehicle-Management-System.git
cd Property-and-Vehicle-Management-System

# Option 2: Download ZIP and extract
# Extract to desired location
```

#### Step 2: Install LAMP Stack

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-mysql mysql-server -y
```

#### Step 3: Start and Enable Services

```bash
sudo systemctl start apache2
sudo systemctl start mysql
sudo systemctl enable apache2
sudo systemctl enable mysql
```

#### Step 4: Create Database and User

```bash
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS rent; CREATE USER IF NOT EXISTS 'pvmuser'@'localhost' IDENTIFIED BY 'pvm123'; GRANT ALL PRIVILEGES ON rent.* TO 'pvmuser'@'localhost'; FLUSH PRIVILEGES;"
```

**Note:** If prompted for MySQL root password, press Enter if no password is set.

#### Step 5: Import Database Schema

```bash
# Navigate to your project directory
cd /path/to/Property-and-Vehicle-Management-System

# Import the schema
mysql -u pvmuser -ppvm123 rent < rental-tables-with-relationships.sql
```

#### Step 6: Deploy to Apache

```bash
# Copy project to Apache web directory
sudo cp -r /path/to/Property-and-Vehicle-Management-System /var/www/html/

# Set proper ownership and permissions
sudo chown -R www-data:www-data /var/www/html/Property-and-Vehicle-Management-System
sudo chmod -R 755 /var/www/html/Property-and-Vehicle-Management-System

# Restart Apache
sudo systemctl restart apache2
```

#### Step 7: Access the Application

Open your web browser and navigate to:
```
http://localhost/Property-and-Vehicle-Management-System/login.php
```

---

### Quick Development Server

For quick testing without Apache setup:

```bash
# Navigate to project directory
cd /path/to/Property-and-Vehicle-Management-System

# Install PHP and MySQL (if not already installed)
sudo apt install php php-mysql mysql-server -y

# Setup database (steps 4-5 from above)
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS rent; CREATE USER IF NOT EXISTS 'pvmuser'@'localhost' IDENTIFIED BY 'pvm123'; GRANT ALL PRIVILEGES ON rent.* TO 'pvmuser'@'localhost'; FLUSH PRIVILEGES;"
mysql -u pvmuser -ppvm123 rent < rental-tables-with-relationships.sql

# Start PHP built-in server
php -S localhost:8080
```

Open your browser and visit: `http://localhost:8080/login.php`

---

### Windows (XAMPP)

1. **Download and install [XAMPP](https://www.apachefriends.org/)**

2. **Copy the project folder** to `C:\xampp\htdocs\`

3. **Start Apache and MySQL** from XAMPP Control Panel

4. **Create database:**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database named `rent`
   - Import `rental-tables-with-relationships.sql`

5. **Create database user:**
   - In phpMyAdmin, go to User accounts → Add user account
   - Username: `pvmuser`
   - Password: `pvm123`
   - Grant all privileges on database `rent`

6. **Access the application:**
   ```
   http://localhost/Property-and-Vehicle-Management-System/login.php
   ```

---

### macOS (MAMP)

1. **Download and install [MAMP](https://www.mamp.info/)**

2. **Copy the project folder** to `/Applications/MAMP/htdocs/`

3. **Start MAMP servers** (Apache and MySQL)

4. **Create database:**
   - Open phpMyAdmin from MAMP start page
   - Create new database named `rent`
   - Import `rental-tables-with-relationships.sql`

5. **Create database user:**
   - Username: `pvmuser`
   - Password: `pvm123`
   - Grant all privileges on database `rent`

6. **Access the application:**
   ```
   http://localhost:8888/Property-and-Vehicle-Management-System/login.php
   ```

---

## 🗄️ Database Configuration

The application connects to the database using the following default credentials:

| Setting | Default Value |
|---------|---------------|
| Host | localhost |
| Username | pvmuser |
| Password | pvm123 |
| Database | rent |
| Port | 3306 |

### Using Environment Variables

You can override database settings using environment variables:

```bash
export DB_HOST=localhost
export DB_USERNAME=pvmuser
export DB_PASSWORD=pvm123
export DB_NAME=rent
export DB_PORT=3306
```

Or modify `connection.php` directly if needed.

---

## ✅ Testing Your Setup

After installation, verify everything is working:

### Test Database Connection

```bash
cd /path/to/Property-and-Vehicle-Management-System
php -r 'require "connection.php"; echo ($conn ? "DB OK\n" : "DB FAILED\n");'
```

Expected output: `DB OK`

### Test Web Access

Open your browser and navigate to the login page. You should see the login form.

---

## 🔍 Troubleshooting

### Database Connection Failed

**Issue:** `DB FAILED` message or connection errors

**Solutions:**
```bash
# Check if MySQL is running
sudo systemctl status mysql

# Start MySQL if not running
sudo systemctl start mysql

# Verify database and user exist
mysql -u pvmuser -ppvm123 -e "SHOW DATABASES;"
```

### PHP mysqli Extension Missing

**Issue:** Error about mysqli extension

**Solution:**
```bash
# Install PHP MySQL extension
sudo apt install php-mysql

# Restart Apache
sudo systemctl restart apache2
```

### 403 Forbidden or Permission Errors

**Issue:** Cannot access files in browser

**Solution:**
```bash
# Fix ownership and permissions
sudo chown -R www-data:www-data /var/www/html/Property-and-Vehicle-Management-System
sudo chmod -R 755 /var/www/html/Property-and-Vehicle-Management-System

# Restart Apache
sudo systemctl restart apache2
```

### Apache Not Starting

**Issue:** Apache fails to start

**Solution:**
```bash
# Check for errors
sudo systemctl status apache2
sudo journalctl -u apache2 -n 50

# Check if port 80 is in use
sudo netstat -tlnp | grep :80

# Restart Apache
sudo systemctl restart apache2
```

### Page Not Found (404)

**Issue:** Cannot find the application

**Solution:**
- Verify project is in `/var/www/html/` directory
- Check the URL includes the project folder name
- Ensure Apache is running: `sudo systemctl status apache2`

---

## 📁 Project Structure

```
Property-and-Vehicle-Management-System/
├── connection.php                          # Database connection
├── login.php                               # Login page (entry point)
├── signup_cu.php                          # Customer signup
├── signup_ow.php                          # Owner signup
├── logout.php                             # Logout handler
├── owner_dashboard.php                    # Owner dashboard
├── customer_dashboard.php                 # Customer dashboard
├── add_property.php                       # Add new property
├── add_vehicle.php                        # Add new vehicle
├── reserve.php                            # Reservation handler
├── fetch_properties.php                   # Fetch properties data
├── fetch_properties_by_status.php         # Filter properties by status
├── fetch_vehicles.php                     # Fetch vehicles data
├── fetch_vehicles_by_status.php           # Filter vehicles by status
├── rental-tables-with-relationships.sql   # Database schema
└── README.md                              # This file
```

---

## 📝 Notes

- Default database credentials are for development only. Change them for production use.
- Make sure to secure your database with strong passwords in production environments.
- This application is intended for educational purposes and local development.

---

## 📧 Support

If you encounter any issues during setup, please:
1. Check the [Troubleshooting](#troubleshooting) section
2. Verify all requirements are met
3. Check Apache and MySQL error logs

---

## 📄 License

This project is open source and available for educational purposes.
