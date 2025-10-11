# Sử dụng image PHP chính thức
FROM php:8.2-apache

# Cài các extension cần thiết cho Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Sao chép mã nguồn vào container
WORKDIR /var/www/html
COPY . .

# Cấp quyền cho Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Cài dependencies và optimize
RUN composer install --no-dev --optimize-autoloader && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Mở port
EXPOSE 8080

# Chạy Laravel
CMD php artisan serve --host 0.0.0.0 --port 8080
