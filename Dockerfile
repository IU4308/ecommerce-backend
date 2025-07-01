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

# Enable Apache headers module (for CORS)
RUN a2enmod headers

# Copy the full app into the container
COPY . /var/www/html/

# Install PHP dependencies
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# Ensure init.sh is executable
RUN chmod +x /var/www/html/init.sh

# Start script
CMD ["/var/www/html/init.sh"]
