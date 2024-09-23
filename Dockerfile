# Use the official PHP 8.1 CLI image as the base
FROM php:8.1-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
  git \
  unzip \
  && docker-php-ext-install pdo pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# Copy the rest of the application code
COPY . .

# Expose port 8000
EXPOSE 8000

# Start the PHP built-in server
CMD [ "php", "-S", "0.0.0.0:8000", "-t", "." ]
