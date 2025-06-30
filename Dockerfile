FROM php:8.2-apache

# Install MariaDB server and PHP MySQL driver
RUN apt-get update && \
    apt-get install -y mariadb-server && \
    docker-php-ext-install pdo pdo_mysql

# Make Apache listen on 0.0.0.0:80 so Render can detect it
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

# Copy PHP app and DB initialization script
COPY index.php /var/www/html/
COPY init.sql /init.sql

# Start MariaDB, initialize the DB, and then start Apache
CMD bash -c "mysqld_safe & \
    sleep 5 && \
    mysql -u root -e 'CREATE DATABASE IF NOT EXISTS mydb; USE mydb; source /init.sql;' && \
    apache2-foreground"