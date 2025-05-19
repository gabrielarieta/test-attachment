FROM php:8.2-fpm

# Copy composer.lock and composer.json into the working directory
COPY ./src/api/composer.lock ./src/api/composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    zip \
    vim \
    git \
    curl

# Install extensions for php
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY ./src/api /var/www/html

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data /var/www/html/storage 
RUN chown -R www-data:www-data  /var/www/html/bootstrap/cache

RUN composer install

RUN php artisan storage:link

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
