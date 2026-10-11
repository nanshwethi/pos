FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    git \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    $PHPIZE_DEPS

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

# Install Redis extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Clean up to reduce image size
RUN apk del $PHPIZE_DEPS && \
    rm -rf /tmp/* /var/cache/apk/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install Laravel dependencies with error handling
RUN composer install --no-dev --optimize-autoloader --no-interaction || \
    (echo "Composer install failed. Check your configuration." && exit 1)

# Copy configs
COPY docker-coolify/nginx.conf /etc/nginx/http.d/default.conf
COPY docker-coolify/supervisord.conf /etc/supervisord.conf
COPY docker-coolify/php.ini /usr/local/etc/php/conf.d/uploads.ini

# Create required directories
RUN mkdir -p /run/nginx /var/log/supervisor /var/www/storage/framework/{sessions,views,cache}

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 775 /var/www/storage/framework \
    && chmod -R 775 /var/www/storage/logs

# Generate application key (if .env exists)
RUN if [ -f .env ]; then php artisan key:generate --force || true; fi

# Optimize Laravel
RUN php artisan config:cache || true && \
    php artisan route:cache || true && \
    php artisan view:cache || true

# Expose port
EXPOSE 80

# Start all services
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]