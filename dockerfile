FROM serversideup/php:8.2-fpm-nginx-alpine-v3.0.1

# Copy custom Nginx config
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html
COPY . .

# Install Composer & PHP deps
RUN composer install --no-dev --optimize-autoloader

# Build Vue assets
RUN apk add --no-cache nodejs npm \
 && npm ci \
 && npm run build \
 && rm -rf node_modules

# Laravel caches
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Make start script runnable
RUN chmod +x /var/www/html/start.sh

EXPOSE 80
CMD ["/start.sh"]
