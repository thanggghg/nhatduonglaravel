FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    postgresql-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Custom PHP configuration (upload limits, memory, etc.)
COPY docker/php/local.ini /usr/local/etc/php/conf.d/zz-local.ini

# Set working directory
WORKDIR /var/www

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
