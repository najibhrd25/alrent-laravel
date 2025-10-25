# Gunakan base image PHP 8.2 yang sudah lengkap
FROM php:8.2-cli

# Install dependency dasar
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set workdir
WORKDIR /app

# Copy semua file Laravel ke container
COPY . .

# Install composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Expose port Laravel
EXPOSE 8000

# Jalankan Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
