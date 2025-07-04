# Use maintained PHP-FPM + Nginx image with S6 process supervisor
FROM serversideup/php:8.2-fpm-nginx-alpine

USER root

# Install required PHP extensions
RUN install-php-extensions pdo_pgsql gd redis zip

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Ensure Laravel folders are writable
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 755 storage bootstrap/cache

# Install PHP dependencies
USER www-data
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build Vue assets
USER root
RUN apk add --no-cache nodejs npm \
 && npm ci \
 && npm run build \
 && rm -rf node_modules

# Optimize Laravel performance
USER www-data
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Ensure startup script exists and is executable
USER root
RUN chmod +x /var/www/html/start.sh \
 && chown www-data:www-data /var/www/html/start.sh

# Expose HTTP default port
EXPOSE 80

# Run startup script (migrations) and let S6 manage services
ENTRYPOINT ["/var/www/html/start.sh"]
