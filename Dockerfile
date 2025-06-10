FROM php:8.2-apache

# Cài các gói cần thiết để build PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Bật mod_rewrite cho Laravel
RUN a2enmod rewrite

# Set document root về /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copy mã nguồn vào container
WORKDIR /var/www/html
COPY . .

# Cài Composer (lấy từ official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cài Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

# Clear cache + cấp quyền
RUN php artisan config:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

EXPOSE 80
