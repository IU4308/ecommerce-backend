FROM php:8.2-apache

# Install MariaDB and PHP MySQL extensions
RUN apt-get update && \
    apt-get install -y mariadb-server mariadb-client && \
    docker-php-ext-install pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Apache to bind on all interfaces (for Render)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

# Copy app and startup files
COPY index.php /var/www/html/
COPY init.sql /init.sql
COPY init.sh /init.sh
RUN chmod +x /init.sh

CMD ["/init.sh"]
