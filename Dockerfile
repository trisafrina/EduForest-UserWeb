FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

EXPOSE 80