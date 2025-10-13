# --- Base image ---
FROM php:8.2-apache

# --- Cài extension cần thiết ---
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# --- Cài Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Copy source ---
WORKDIR /var/www/html
COPY . .

# --- Copy .env.example nếu chưa có ---
RUN cp .env.example .env || true

# --- Phân quyền ---
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# --- Cài đặt dependencies ---
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# --- Port Render ---
ENV PORT=8080
EXPOSE 8080

# --- CMD thay ENTRYPOINT để đọc ENV đúng thời điểm ---
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force || true && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=$PORT