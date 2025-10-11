# Base image PHP 8.2 + Composer + NodeJS
FROM composer:2.7 AS build

WORKDIR /app

# Copy toàn bộ project
COPY . .

# Cài dependency PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Tạo bản production
FROM php:8.2-apache

# Cài extension Laravel cần
RUN docker-php-ext-install pdo pdo_mysql

# Copy project từ image trước
COPY --from=build /app /var/www/html

# Cấu hình quyền truy cập
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Laravel cần file .env và storage quyền ghi
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port HTTP
EXPOSE 80

# Chạy server Apache
CMD ["apache2-foreground"]
