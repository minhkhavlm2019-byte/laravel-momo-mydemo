# ==============================
# 1️⃣ Stage 1: Build dependencies bằng Composer
# ==============================
FROM composer:2.7 AS build

WORKDIR /app

# Copy file composer
COPY composer.json composer.lock ./

# Cài các package PHP (không cài dev)
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Copy toàn bộ source code
COPY . .

# ⚠️ Không chạy artisan ở đây (Render không có .env trong stage build)
# Bạn có thể cache sau trong container runtime nếu cần.

# ==============================
# 2️⃣ Stage 2: Chạy Laravel bằng PHP + Apache
# ==============================
FROM php:8.2-apache

# Cài extension PHP cần cho Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd && \
    a2enmod rewrite

# Cấu hình Apache trỏ đến thư mục public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# ⚙️ Thêm quyền truy cập và cho phép .htaccess hoạt động
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel

# Copy code từ stage build sang
COPY --from=build /app /var/www/html

# Phân quyền để Apache truy cập
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/public

# Mở port HTTP
EXPOSE 80

# Khởi chạy Apache
CMD ["apache2-foreground"]
