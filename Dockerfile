# Gunakan PHP dengan Debian Bookworm yang stabil
FROM php:8.2-cli-bookworm

# Install dependency dasar Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Atur direktori kerja
WORKDIR /app

# Copy semua file Laravel ke container
COPY . .

# Install Composer (ambil langsung dari image resminya)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Expose port default Laravel
EXPOSE 8000

# Jalankan migrasi dan start server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
