# Use a modern base with Nginx + PHP-FPM
FROM dwchiang/nginx-php-fpm:8.2-alpine

# Copy custom Nginx configuration
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Set working directory
WORKDIR /var/www/html

# Copy all application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies & build Vue (Breeze / Vite)
RUN apk update && apk add --no-cache nodejs npm \
 && npm ci \
 && npm run build \
 && rm -rf node_modules

# Cache Laravel configuration and views
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Ensure start script is executable
RUN chmod +x /var/www/html/start.sh

# Expose HTTP port
EXPOSE 80

# Launch the app
CMD ["/start.sh"]
