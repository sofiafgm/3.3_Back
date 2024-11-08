# Use the official PHP 8.0 image with Apache
FROM php:8.0-apache

# Install system dependencies and PHP extensions needed by Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring exif bcmath zip intl

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Laravel app into the container
COPY . /var/www/html

# Set the correct permissions for Laravel (adjust according to your needs)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Expose the port Apache is listening on
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]