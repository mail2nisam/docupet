#!/bin/bash

# Install additional dependencies
apt-get update && apt-get install -y \
    git \
    curl \
    default-mysql-client \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
cp composer.json composer.lock ./
composer install --no-scripts --no-autoloader

# Generate autoload files
composer dump-autoload --no-scripts --optimize

# Install Symfony CLI
curl -sS https://get.symfony.com/cli/installer | bash
mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Check Symfony requirements
symfony check:requirements

# Execute the command provided as arguments to the script
exec "$@"
