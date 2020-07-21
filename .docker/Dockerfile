FROM php:7.3-fpm-alpine

# Install apk packages we want
RUN apk add -Uuv \
    git \
    bash \
    supervisor \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    libpng-dev \
    && rm -rf /var/cache/apk/*

# Download and install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy and install composer dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .
RUN chmod +x artisan

# Create the database file and run the migrations
RUN touch database/database.sqlite \
    && php artisan migrate --force

# Expose port 8000 and start php-fpm server
EXPOSE 8000
CMD php -S 0.0.0.0:8000 -t public
