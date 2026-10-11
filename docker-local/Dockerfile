FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    git curl zip unzip supervisor \
    libpng-dev oniguruma-dev libxml2-dev icu-dev \
    libzip-dev postgresql-dev \
    freetype-dev libjpeg-turbo-dev libwebp-dev \
    $PHPIZE_DEPS

# Configure GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql mbstring exif pcntl bcmath gd intl zip

# Redis
RUN pecl install redis && docker-php-ext-enable redis

# Cleanup
RUN apk del $PHPIZE_DEPS

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www

# Supervisor config
COPY docker-local/supervisord.conf /etc/supervisord.conf

# Entrypoint
COPY docker-local/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]