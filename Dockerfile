# =========================================================
# 🧱 STAGE 1: Composer dependencies
# =========================================================
FROM composer:2.6 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

# Giữ cache để lần sau build nhanh hơn
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# =========================================================
# 🧱 STAGE 2: PHP + Apache + Laravel setup
# =========================================================
FROM php:8.2-apache

# Cài các extension PHP cần cho Laravel + MoMo
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy composer dependencies từ stage 1
COPY --from=vendor /app/vendor /var/www/html/vendor

# Copy toàn bộ project Laravel
WORKDIR /var/www/html
COPY . .

# Tạo storage và bootstrap/cache (nếu chưa có)
RUN mkdir -p storage bootstrap/cache

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Bật Apache mod_rewrite cho Laravel routes
RUN a2enmod rewrite

# Chỉnh VirtualHost để đọc biến PORT do Render cung cấp
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf

# Expose port cho Render / Koyeb
EXPOSE 10000

# Tự động optimize + migrate khi container khởi động
CMD php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force || true && \
    apache2-foreground
