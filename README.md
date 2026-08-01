## Property-and-Vehicle-Management-System
## Property-and-Vehicle-Management-System

Simple PHP/MySQL application to manage properties and vehicles.

## Quick overview

- Entry page: `login.php`
- Database schema: `rental-tables-with-relationships.sql`

## Requirements

- PHP 7.4+ with `mysqli`/`pdo_mysql` extension
- MySQL or MariaDB
- (Optional) Apache or another web server

## Environment variables

The app reads DB settings from environment variables in `connection.php`. You can set:

- `DB_HOST` (default: 127.0.0.1)
- `DB_USERNAME` (default: pvmuser)
- `DB_PASSWORD` (default: pvm123)
- `DB_NAME` (default: rent)
- `DB_PORT` (default: 3306)

Example (Linux/macOS):

```bash
export DB_HOST=127.0.0.1
export DB_USERNAME=pvmuser
export DB_PASSWORD=pvm123
export DB_NAME=rent
export DB_PORT=3306
```

## Setup and run (recommended: Ubuntu/Debian)

1. Install LAMP components:

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-mysql mysql-server -y
```

2. Create database and user (run as root or with `sudo`):

```bash
sudo mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS rent; CREATE USER IF NOT EXISTS 'pvmuser'@'localhost' IDENTIFIED BY 'pvm123'; GRANT ALL PRIVILEGES ON rent.* TO 'pvmuser'@'localhost'; FLUSH PRIVILEGES;"
```

3. Import the schema (from the project root):

```bash
mysql -u pvmuser -p rent < rental-tables-with-relationships.sql
```

4. Place the project in Apache's webroot (if not already):

```bash
sudo cp -r /path/to/Property-and-Vehicle-Management-System /var/www/html/
sudo chown -R www-data:www-data /var/www/html/Property-and-Vehicle-Management-System
sudo find /var/www/html/Property-and-Vehicle-Management-System -type d -exec chmod 755 {} \;
sudo find /var/www/html/Property-and-Vehicle-Management-System -type f -exec chmod 644 {} \;
sudo systemctl restart apache2
```

5. Open in your browser:

```
http://localhost/Property-and-Vehicle-Management-System/login.php
```

## Quick dev run (no Apache)

If you prefer a quick local server for development:

```bash
cd /path/to/Property-and-Vehicle-Management-System
# make sure MySQL is running and DB/schema imported
php -S localhost:8080
```

Open: `http://localhost:8080/login.php`

If you run the server from inside the project folder, omit the project folder from the URL.

## Windows (XAMPP) or macOS (MAMP)

- Copy the project folder into XAMPP/MAMP `htdocs`.
- Use phpMyAdmin to create the `rent` database and import `rental-tables-with-relationships.sql`.
- Start Apache & MySQL via the control panel. Open `http://localhost/Property-and-Vehicle-Management-System/login.php`.

## Test DB connection

From the project root, run:

```bash
php -r 'require "connection.php"; echo ($conn ? "DB OK\n" : "DB FAILED\n");'
```

If you see `DB FAILED`, check MySQL is running, credentials, and that PHP has the `mysqli` extension installed.

## Troubleshooting

- MySQL not running: `sudo systemctl start mysql` and inspect `sudo journalctl -u mysql -n 200`.
- PHP missing mysqli: `sudo apt install php-mysql` then restart Apache.
- Permission issues: ensure `www-data` owns the project under `/var/www/html`.
- If using PHP dev server, remember it does not run as `www-data`; file permissions can still block logs/uploads.

## Notes

- This repository no longer contains a Docker setup; instructions above describe running without Docker.
- If you change DB credentials, either update environment variables or edit `connection.php` accordingly.

## Files of interest

- `connection.php` — DB connection (reads env vars)
- `rental-tables-with-relationships.sql` — DB schema
- `login.php` — app entry page

If you want, I can: (A) create a small `health.php` check script, (B) run the DB creation/import commands for you, or (C) create an Apache vhost file — tell me which.
