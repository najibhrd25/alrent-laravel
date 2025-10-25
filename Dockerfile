FROM php:8.3-apache

# Gunakan mirror cepat dan non-interaktif agar tidak hang
RUN sed -i 's|deb.debian.org|deb.debian.org/debian|g' /etc/apt/sources.list \
    && apt-get clean \
    && apt-get update -o Acquire::Retries=3 -o Acquire::http::No-Cache=True -o Acquire::http::Pipeline-Depth=0 \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
