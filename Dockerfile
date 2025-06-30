FROM php:8.2-apache

# Install MySQL and PHP extensions
RUN apt-get update && \
    apt-get install -y default-mysql-server default-mysql-client && \
    docker-php-ext-install pdo pdo_mysql

# Copy PHP file
COPY index.php /var/www/html/

# Copy init.sql
COPY init.sql /init.sql

# Start MySQL and Apache together
CMD service mysql start && \
    sleep 5 && \
    mysql -u root -e "source /init.sql" && \
    apache2-foreground
