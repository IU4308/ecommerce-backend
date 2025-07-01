#!/bin/bash

mysqld_safe &

until mysqladmin ping --silent; do
  echo "Waiting for MariaDB to start..."
  sleep 1
done

pgrep mysqld || { echo "[ERROR] MariaDB is not running!"; exit 1; }

echo "[INFO] Switching root auth plugin to mysql_native_password..."
mysql -u root <<EOF
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('');
FLUSH PRIVILEGES;
EOF

mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS mydb;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppassword';
GRANT ALL PRIVILEGES ON mydb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;
USE mydb;
SOURCE /var/www/html/init.sql;
EOF

mysql -u root mydb -e "SHOW TABLES LIKE 'products'\G" | grep -q "products"
if [ $? -ne 0 ]; then
  echo "Initializing DB schema..."
  mysql -u root mydb < /var/www/html/init.sql
else
  echo "DB schema already exists. Skipping init.sql."
fi

apache2-foreground
