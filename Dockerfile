# Base PHP + Apache
FROM php:8.2-apache

# Cài các extension cần thiết cho Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Làm việc trong thư mục app
WORKDIR /var/www/html

# Copy toàn bộ source
COPY . .

# Cấp quyền cho Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Cài dependencies (chỉ build, chưa chạy artisan)
RUN composer install --no-dev --optimize-autoloader

# Expose port 8080
EXPOSE 8080

# Khi container chạy, mới chạy artisan setup
CMD php artisan key:generate --force && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host 0.0.0.0 --port 8080
