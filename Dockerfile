# ===============================
# 🐘 Build Laravel on PHP 8.2 + Apache
# ===============================

# Base image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer binary from official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files into container
COPY . .

# Install dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy the default environment if missing
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Generate Laravel APP_KEY
RUN php artisan key:generate --force

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Configure Apache to serve the /public directory
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Start Apache
CMD ["apache2-foreground"]
