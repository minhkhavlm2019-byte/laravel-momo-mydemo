# ==============================
# 1️⃣ Stage 1: Build composer dependencies
# ==============================
FROM composer:2.7 AS build

WORKDIR /app

# Copy file cấu hình composer
COPY composer.json composer.lock ./

# Cài dependency nhưng không cần autoloader dev
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Copy toàn bộ source code Laravel vào container build
COPY . .

# Build các cache Laravel (tăng tốc độ)
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# ==============================
# 2️⃣ Stage 2: Runtime image với PHP + Apache
# ==============================
FROM php:8.2-apache

# Cài các extension cần thiết cho Laravel & MySQL
RUN apt-get update && apt-get install -y \
    zip unzip git libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd && \
    a2enmod rewrite

# Đặt DocumentRoot của Apache trỏ vào thư mục /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copy toàn bộ project từ stage build
COPY --from=build /app /var/www/html

# Phân quyền cho Laravel
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Mở cổng web
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
