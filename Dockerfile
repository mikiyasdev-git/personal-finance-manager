FROM php:8.3-cli

# Install system dependencies and PHP extensions
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

# Application directory
WORKDIR /var/www/html

# Copy Composer files first for better Docker layer caching
COPY composer.json composer.lock ./

# Install production PHP dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader

# Copy the Laravel application
COPY . .

# Generate optimized Composer autoloader
RUN composer dump-autoload --optimize

# Make Laravel storage and cache directories writable
RUN chmod -R 775 storage bootstrap/cache

# Start Laravel using Render's PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
