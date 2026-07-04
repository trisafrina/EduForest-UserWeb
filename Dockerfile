FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN npm ci --include=dev
RUN npm run build

RUN test -f public/build/manifest.json && echo "✅ Vite manifest built successfully" \
    || (echo "❌ VITE BUILD FAILED: manifest.json was not created" && exit 1)

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

RUN chown -R www-data:www-data storage bootstrap/cache

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80
