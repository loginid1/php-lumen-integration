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

# Install wait-for-it
RUN curl https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh > /opt/wait-for-it.sh \
    && chmod +x /opt/wait-for-it.sh \
    && ln -s /opt/wait-for-it.sh /usr/bin/wait-for-it

# Download and install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory permissions
COPY . .
RUN composer install

# Create the database file and run the migrations
RUN touch database/database.sqlite \
    && php artisan migrate

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
