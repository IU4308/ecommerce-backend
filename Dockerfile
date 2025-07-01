FROM php:8.2-apache

# Install dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y \
        mariadb-server mariadb-client \
        unzip curl git && \
    docker-php-ext-install pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache to bind on all interfaces (for Render)
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

# Copy app and startup files
COPY composer.json composer.lock /var/www/html/
RUN cd /var/www/html && composer install
COPY src/ /var/www/html/src/
COPY public/index.php /var/www/html/
COPY init.sql /init.sql
COPY init.sh /init.sh
RUN chmod +x /init.sh

CMD ["/init.sh"]
