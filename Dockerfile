# --- Base image ---
FROM php:8.2-apache

# --- Cài các extension cần cho Laravel + PostgreSQL ---
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# --- Cài Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Copy source code ---
WORKDIR /var/www/html
COPY . .

# --- Copy .env.example làm mẫu (Render sẽ override bằng .env thật) ---
RUN cp .env.example .env

# --- Phân quyền cho storage & cache ---
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# --- Cài đặt dependencies ---
RUN composer install --no-dev --optimize-autoloader

# --- Render dùng port 8080 ---
ENV PORT=8080
EXPOSE 8080

# --- Chạy app ---
CMD php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan key:generate --force \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan serve --host=0.0.0.0 --port=$PORT
