FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set application directory
WORKDIR /var/www/html

# Copy Composer files first for better Docker caching
COPY composer.json composer.lock ./

# Install production PHP dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copy application
COPY . .

# Laravel needs these directories writable
RUN chmod -R 775 storage bootstrap/cache

# Render provides the PORT environment variable
CMD sh -c "php artisan optimize && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
