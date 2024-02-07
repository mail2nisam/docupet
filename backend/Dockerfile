# Use the official PHP image with PHP-FPM as base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/backend

# Install additional dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    default-mysql-client \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate autoload files
RUN composer dump-autoload --no-scripts --optimize


RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony
RUN symfony check:requirements
# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["symfony", "server:start", "--no-tls", "--port=9000"]
