FROM php:8.2-apache

# Cài các thư viện cần thiết, bao gồm GD
RUN apt-get update && apt-get install -y \
    zip unzip curl git \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Bật rewrite module cho Apache
RUN a2enmod rewrite

# Set Laravel public làm thư mục root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set thư mục làm việc
WORKDIR /var/www/html

# Copy source vào container
COPY . .

# Copy composer từ official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Clear config + set quyền
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html
