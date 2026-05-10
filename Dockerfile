FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
        libpq-dev libzip-dev zip unzip curl \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && a2enmod rewrite

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN printf '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm ci && npm run build \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link --force \
    && php artisan migrate --force \
    && php artisan db:seed --force \
    && apache2-foreground
