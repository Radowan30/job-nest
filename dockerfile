FROM serversideup/php:8.2-fpm-nginx-alpine

USER root
RUN install-php-extensions pdo_pgsql gd redis zip

WORKDIR /var/www/html
COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 755 storage bootstrap/cache

USER www-data
RUN composer install --no-dev --optimize-autoloader --no-interaction

USER root
RUN apk add --no-cache nodejs npm \
 && npm ci \
 && npm run build \
 && rm -rf node_modules

USER www-data
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

USER root
RUN chmod +x /var/www/html/start.sh \
 && chown www-data:www-data /var/www/html/start.sh

EXPOSE 80
CMD ["/var/www/html/start.sh"]
