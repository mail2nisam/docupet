# Use the official PHP image with PHP-FPM as base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/backend

# Copy project files
COPY . .

# Copy entrypoint script into the container
COPY entrypoint.sh /usr/local/bin/

# Make the entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Set the entrypoint to the script
ENTRYPOINT ["entrypoint.sh"]

# Start PHP-FPM
CMD ["symfony", "server:start", "--no-tls", "--port=9000"]
