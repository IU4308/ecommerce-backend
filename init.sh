#!/bin/bash
mysqld_safe &

until mysqladmin ping --protocol=tcp -h 127.0.0.1 --silent; do
  echo "Waiting for MariaDB to start..."
  sleep 1
done

mysql --protocol=tcp -h 127.0.0.1 -u root <<EOF
CREATE DATABASE IF NOT EXISTS mydb;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppassword';
GRANT ALL PRIVILEGES ON mydb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;
USE mydb;
SOURCE /init.sql;
EOF

apache2-foreground
