FROM php:8.2-apache

# Cài GD + các extension cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Laravel public là thư mục chính
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set thư mục làm việc
WORKDIR /var/www/html

# Copy mã nguồn
COPY . .

# Copy composer từ image composer chính thức
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài đặt Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Phân quyền & clear
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html
