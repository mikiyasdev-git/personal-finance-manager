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

# Application directory
WORKDIR /var/www/html

# Copy Composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies without running Laravel scripts yet
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader

# Copy the Laravel application
COPY . .

# Make Laravel directories writable
RUN chmod -R 775 storage bootstrap/cache

# Run Laravel Composer scripts now that the application exists
RUN composer dump-autoload --optimize

# Optimize Laravel
RUN php artisan optimize

# Render provides PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
