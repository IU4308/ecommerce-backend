#!/bin/bash

# Start MariaDB
mysqld_safe &

# Wait for it to become available
until mysqladmin ping --silent; do
  echo "Waiting for MariaDB to start..."
  sleep 1
done

# Sanity check
pgrep mysqld || { echo "[ERROR] MariaDB is not running!"; exit 1; }

# Ensure UTF-8 defaults for client and server
echo "[INFO] Setting character set and collation..."

mysql -u root <<EOF
-- Use utf8mb4 for full Unicode support (emojis, symbols, etc.)
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('');
FLUSH PRIVILEGES;

-- Create database with utf8mb4 charset and collation
CREATE DATABASE IF NOT EXISTS mydb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppassword';
GRANT ALL PRIVILEGES ON mydb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;
EOF

# Ensure the schema is imported with correct charset
mysql --default-character-set=utf8mb4 -u root mydb < /var/www/html/init.sql

# Check if table exists
mysql -u root mydb -e "SHOW TABLES LIKE 'products'\G" | grep -q "products"
if [ $? -ne 0 ]; then
  echo "Initializing DB schema..."
  mysql --default-character-set=utf8mb4 -u root mydb < /var/www/html/init.sql
else
  echo "DB schema already exists. Skipping init.sql."
fi

# Start Apache
exec apache2-foreground
