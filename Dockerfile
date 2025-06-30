FROM php:8.2-apache

# Install MySQL and PHP extensions
RUN apt-get update && \
    apt-get install -y default-mysql-server default-mysql-client && \
    docker-php-ext-install pdo pdo_mysql

COPY index.php /var/www/html/

COPY init.sql /init.sql

# Start MySQL and Apache together
CMD mysqld_safe  && \
    sleep 5 && \
    mysql -u root -e "CREATE DATABASE IF NOT EXISTS mydb; source /init.sql;" && \
    apache2-foreground
