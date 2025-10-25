FROM php:8.2-cli-bookworm

# Gunakan mirror Singapore & non-interaktif
RUN sed -i 's|deb.debian.org|sg.mirrors.cloud.tencent.com|g' /etc/apt/sources.list \
    && apt-get clean \
    && apt-get update -o Acquire::Retries=3 -o Acquire::http::No-Cache=True \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
        git unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
