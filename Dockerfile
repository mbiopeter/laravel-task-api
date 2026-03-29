# Use PHP 8.4 FPM
FROM php:8.4-fpm

# Set environment variables for non-interactive installs
ENV DEBIAN_FRONTEND=noninteractive

# 1. Install System Dependencies & PHP Extension Helper
# This helper handles the complex compilation of mbstring/pdo automatically
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# 2. Install PHP extensions
# Removed json, ctype, and tokenizer as they are built into PHP 8.4 core
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    xml \
    curl \
    zip \
    bcmath

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /app

# 5. Install PHP Dependencies (Layer Caching)
# Copying these first ensures 'composer install' only runs if dependencies change
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# 6. Install Node.js & Build Assets
# Using Node 22 as per your setup
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

COPY package.json package-lock.json* ./
RUN npm install

# 7. Copy Project Files & Finalize
COPY . .
RUN composer dump-autoload --optimize

# Build production assets
RUN npm run build

# 8. Set Permissions
# Ensuring Laravel has write access to necessary folders
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 9. Deployment Command
# Railway usually prefers 8080. Using 'serve' is okay for small apps, 
# but consider 'php-fpm' or 'octane' for high-traffic production.
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]