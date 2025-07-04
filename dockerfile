# Use a maintained PHP-FPM + Nginx image
FROM serversideup/php:8.2-fpm-nginx-alpine-v3.0.1

# Install system dependencies & PHP extensions required by Laravel
USER root
RUN apk update && apk add --no-cache \
    nodejs npm \
    bash \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    oniguruma-dev \
    libxml2-dev \
 && docker-php-ext-configure gd --with-jpeg --with-webp \
 && docker-php-ext-install gd pdo pdo_pgsql mbstring xml zip \
 && pecl install redis \
 && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy app files and set correct permissions
COPY --chown=www-data:www-data . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build Vue assets
RUN npm ci && npm run build && rm -rf node_modules

# Optimize Laravel
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Ensure the startup script is executable
RUN chmod +x /var/www/html/start.sh

EXPOSE 80
CMD ["/start.sh"]
