# Use the official PHP-Apache image
FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable mysqli extension
RUN docker-php-ext-enable mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy the application files to the container
COPY app/ /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80