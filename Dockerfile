# Gunakan image resmi Laravel
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Salin semua file ke dalam image
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Laravel default port
EXPOSE 8000

# Jalankan Laravel menggunakan built-in server
CMD php artisan serve --host=0.0.0.0 --port=8000
