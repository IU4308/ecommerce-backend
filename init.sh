#!/bin/bash

mysqld_safe &

until mysqladmin ping --silent; do
  echo "Waiting for MariaDB to start..."
  sleep 1
done

# Change root auth to mysql_native_password (empty password) using socket auth
mysql -u root <<EOF
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('');
FLUSH PRIVILEGES;
EOF

# Create database, user and initialize schema using the new root password (empty)
mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS mydb;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppassword';
GRANT ALL PRIVILEGES ON mydb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;
USE mydb;
SOURCE /init.sql;
EOF

apache2-foreground
