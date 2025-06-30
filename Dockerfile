FROM php:8.2-apache

# Install MariaDB server and PHP MySQL driver
RUN apt-get update && \
    apt-get install -y mariadb-server mariadb-client && \
    docker-php-ext-install pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Apache to listen on all interfaces for Render
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

# Copy PHP app and DB initialization script
COPY index.php /var/www/html/
COPY init.sql /init.sql

# Entrypoint script to start MariaDB, initialize DB, and launch Apache
CMD bash -c "\
  mysqld_safe & \
  until mysqladmin ping --protocol=tcp -h 127.0.0.1 --silent; do \
    echo 'Waiting for MariaDB to start...'; sleep 1; \
  done; \
  mysql --protocol=tcp -h 127.0.0.1 -u root <<EOF
CREATE DATABASE IF NOT EXISTS mydb;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppassword';
GRANT ALL PRIVILEGES ON mydb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;
USE mydb;
SOURCE /init.sql;
EOF
  apache2-foreground"
