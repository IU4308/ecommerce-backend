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

# Enable Apache modules
RUN a2enmod headers

# Set Apache document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Copy everything
COPY . /var/www/html/

# Install PHP dependencies
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# Make init.sh executable
RUN chmod +x /var/www/html/init.sh

# Start DB and Apache
CMD ["/var/www/html/init.sh"]
